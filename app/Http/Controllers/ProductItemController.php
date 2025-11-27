<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\ProductItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Facades\ProductItemFacade;
use Illuminate\Routing\Controller; 
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductItemController extends Controller
{

    public function index(Request $request)
    {
        //change this for login session
        $user = $this->getUserRole();

        //get all category displayed
        $categories = Category::with('productItems')->get();
        
        // get the selected category ID from the query string
        $categoryId = $request->query('category');

        // if the category ID is set, filter the menu items by category
        if ($categoryId) {
            $productItems = ProductItemFacade::getProductItemsByCategory($categoryId);
        } else {
            $productItems = ProductItem::all();
        }
    
        //Check user and return view for each user
        if ($user == 'customer') {
            return view('product_items.customerMenu', compact('productItems', 'categories'));
        } else {
            return view('product_items.index', compact('productItems', 'categories'));
        }
    }
    
    public function productItemCRUD(Request $request)
    {
        //change this for login session
        $user = $this->getUserRole();

        // get all category displayed
        $categories = Category::WithProductItems()->get();

        // get the selected category ID from the query string
        $categoryId = $request->query('category');

        // if the category ID is set, filter the menu items by category
        if ($categoryId) {
            $productItems = ProductItemFacade::getProductItemsByCategory($categoryId);
        } else {
            $productItems = ProductItem::all();
        }

        return view('product_items.staffMenu', compact('productItems', 'categories'));

    }

    public function create()
    {
        $categories = Category::all();
        return view('product_items.create', compact('categories'));
    }

    public function createProductItem()
    {
        // 从 categories 表读取 id 和 name
        $categories = DB::table('categories')
            ->select('category_id', 'category_name')
            ->orderBy('category_name')
            ->get();

        return view('product_items.createProductItem', compact('categories'));
    }

    public function createProductItemPost(Request $request)
    {
        $user = $this->getUserRole();

        if ($user == 'staff') {
            // $validatedData = $request->validate([
            //     'name' => 'required|string|max:100',
            //     'description' => 'required|string|max:500',
            //     'price' => 'required|numeric|min:1',
            //     'category_id' => [
            //         'required',
            //         Rule::exists('categories', 'category_id'),
            //     ],
            //     'item_cost' => 'required|numeric|min:0',
            // ]);

            $request->validate([
                'product_name'  => 'required',
                'product_price' => 'required',
                'product_image' => 'required',
                'product_desc'  => 'required',
                'available'     => 'required',
                'product_measurement'   => 'required',
                'product_subImage1'     => 'required',
                'product_subImage2'     => 'required',
                'product_subImage3'     => 'required',
                'category_id' => ['required', Rule::exists('categories', 'category_id')->where(function ($query) use ($request) {
                    // Make the category_id check case-insensitive
                    $query->where('category_id', strtolower($request->category_id));
                })],
            ]);
            
            // Get the last Product
            $lastProd = ProductItem::orderBy('product_item_id', 'desc')->first();

            // Handle image uploads
            $productImage = $request->file('product_image') ->store('img', 'public');
            $subImage1 = $request->file('product_subImage1')->store('img', 'public');
            $subImage2 = $request->file('product_subImage2')->store('img', 'public');
            $subImage3 = $request->file('product_subImage3')->store('img', 'public');

           
            // Create the product item
            $productItem = ProductItem::create ([
                'product_name'      => $request->product_name,
                'product_price'     => $request->product_price,
                'product_image'     => $productImage,
                'product_desc'      => $request->product_desc,
                'available'         => $request->available,
                'product_measurement' => $request->product_measurement,
                'product_subImage1' => $subImage1,
                'product_subImage2' => $subImage2,
                'product_subImage3' => $subImage3,
                'category_id'       => $request->category_id,
            ]);

            return redirect()->route('product_items.createProductItem')
                ->with('success', 'Product created successfully.');
        } else {
            // Change to login or create a view-only menu item
            return view('home');
        }
    }

    public function show(ProductItem $productItem)
    {
        return view('product_items.show', compact('productItem'));
    }


    public function editProductItem(Request $request)
    {
        $productItem = ProductItem::find($request->product_item_id);
    
        return view("product_items.editProductItem", compact('productItem'));
    }    
    
    public function editProductItemPost(Request $request, $product_item_id)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:100',
        //     'description' => 'required|string|max:500',
        //     'price' => 'required|numeric|min:1',
        //     'category_id' => [
        //         'required',
        //         Rule::exists('categories', 'category_id'),
        //     ],
        //     'available' => 'required|boolean',
        //     'item_cost' => 'required|numeric|min:0',
        // ]);
        
        $request->validate([
            'product_name' => 'required',
            'product_price' => 'required',
            // 'product_image' => 'required',
            'product_desc' => 'required',
            'available' => 'required',
            'product_measurement' => 'required',
            // 'product_subImage1' => 'required',
            // 'product_subImage2' => 'required',
            // 'product_subImage3' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'category_id')->where(function ($query) use ($request) {
                // Make the category_id check case-insensitive
                $query->where('category_id', strtolower($request->category_id));
            })],
        ]);

        $productItem = ProductItem::find($product_item_id);
        $productItem->product_name  = $request->product_name;
        $productItem->product_price = $request->product_price;
        $productItem->product_desc  = $request->product_desc;
        $productItem->available     = $request->available;
        $productItem->product_measurement   = $request->product_measurement;
        $productItem->category_id           = $request->category_id;
       
        if($request->hasFile('product_image')){
            Storage::delete('public/' . $productItem->product_image);

            $productItem->product_image = $request->file('product_image')->store('img', 'public');
        }

        if($request->hasFile('product_subImage1')){
            Storage::delete('public/' . $productItem->product_subImage1);

            $productItem->product_subImage1 = $request->file('product_subImage1')->store('img', 'public');
        }

        if($request->hasFile('product_subImage2')){
            Storage::delete('public/' . $productItem->product_subImage2);

            $productItem->product_subImage2 = $request->file('product_subImage2')->store('img', 'public');
        }

        if($request->hasFile('product_subImage3')){
            Storage::delete('public/' . $productItem->product_subImage3);

            $productItem->product_subImage3 = $request->file('product_subImage3')->store('img', 'public');
        }

        $productItem->save();

        
        return redirect()->route('product_items.editProductItem',['product_item_id' => $productItem->product_item_id])->with('success', 'Product item updated successfully.');    

        
    }

    public function destroy(string $productItem)
    {
       
        $deleteProductItem = ProductItem::findOrFail($productItem);

        $deleteProductItem->delete();
        
        return redirect()->back()->with('success', 'Product item deleted successfully.');
    }

    public function getUserRole()
    {
        
        if(isset(auth()->user()->user_id)) {
            //Just check user has what role, if it is staff show crud, if normal leave it
            $user = User::where('user_id', auth()->user()->user_id)->first();

            if ($user && in_array($user->role, ['staff', 'customer'])) {
                return $user->role;
            }
        }

        return null;
    }

    public function productDetails($product_item_id)
    {
        $productItem = ProductItem::find($product_item_id);

        if(!$productItem)
        {
            abort(404);
        }

        return view('product_Items.productDetails',['productItem' => $productItem]);
    }

    public function showProductList()
    {
        $productItems = ProductItem::all();
       
        return view('product_items.productList', compact('productItems'));
    }
}

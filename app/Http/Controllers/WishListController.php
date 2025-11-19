<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\WishList;
use App\Models\ProductItem;
use App\Models\WishListItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WishListController extends Controller
{

    public function getCustomerWishList()
    {
        $customer = Customer::where('user_id', auth()->user()->user_id)->first();
        
        // Assuming you want to retrieve all WishLists for the customer
        $wishLists = WishList::where('customer_id', $customer->user_id)->get();
    
       
        return view('wishList', compact('wishLists'));
    }
    

    public function addWishList(ProductItem $productItem)
    {
        // Get current customer
        $customer = $this->getCurrentCustomer();

        // Check if the product item already exists in the cart
        $existingWishListItem = WishListItem::where('wishList_id', $customer->wishList->wishList_id)
            ->where('product_item_id', $productItem->product_item_id)
            ->first();

        if ($existingWishListItem) {
            // Update the quantity of the existing cart item
            $existingWishListItem->save();
        } else {
            // Create a new cart item
            WishListItem::create([
                'wishList_id'      => $customer->wishList->wishList_id,
                'product_item_id' => $productItem->product_item_id,
            ]);
        }

        $wishList = WishList::find($customer->wishList->wishList_id);

        // Return back and show successful message
        return redirect()->route('product_items.index')->with('success', 'Product successfully added to your wishList.');
    }

    public function removeWishListItem(string $productItem)
    {
        // Get current customer
        $customer = $this->getCurrentCustomer();

        // Delete the requested cart Item
        $wishListItem = WishListItem::where('product_item_id', $productItem)
            ->where('wishList_id', $customer->wishList->wishList_id)
            ->first();

        $wishListItem->delete();
         
        // Redirect to cart page and display success message
        return redirect()->route('getWishList')->with('success', 'Product successfuly removed');
    }


    public function addWishToCartItem(ProductItem $productItem)
    {
        // Get current customer
        $customer = $this->getCurrentCustomer();

        // Check if the product item already exists in the cart
        $existingCartItem = CartItem::where('cart_id', $customer->cart->cart_id)
            ->where('product_item_id', $productItem->product_item_id)
            ->first();

        if ($existingCartItem) {
            // Update the quantity of the existing cart item
            $existingCartItem->quantity += 1;
            $existingCartItem->save();
        } else {
            // Create a new cart item
            CartItem::create([
                'cart_id'      => $customer->cart->cart_id,
                'product_item_id' => $productItem->product_item_id,
                'quantity'     => 1,
            ]);
        }

        $cart = Cart::find($customer->cart->cart_id);
        $this->updated($cart);


        $wishListItem = WishListItem::where('product_item_id', $productItem->product_item_id)
        ->where('wishList_id', $customer->wishList->wishList_id)
        ->first();

        $wishListItem->delete();
        
        // Return back and show successful message
        return redirect()->route('getWishList')->with('success', 'Product successfully added to your cart.');
    }

    public function addAllToCart(ProductItem $productItem)
    {
        // Get current customer
        $customer = $this->getCurrentCustomer();

        // Get wish list items for the current customer
        $wishListItems = $customer->wishlist->wishListItems;


        foreach ($wishListItems as $wishListItem) {
            // Check if the product item already exists in the cart
            $existingCartItem = CartItem::where('cart_id', $customer->cart->cart_id)
                ->where('product_item_id', $wishListItem->product_item_id)
                ->first();
                
            if ($existingCartItem) {
                // Update the quantity of the existing cart item
                $existingCartItem->quantity += 1;
                $existingCartItem->save();
            } else {
                // Create a new cart item
                CartItem::create([
                    'cart_id'          => $customer->cart->cart_id,
                    'product_item_id'  => $wishListItem->product_item_id,
                    'quantity'         => 1,
                ]);
            }
            $cart = Cart::find($customer->cart->cart_id);
            $this->updated($cart);
           
            $wishListItem = WishListItem::where('product_item_id', $wishListItem->product_item_id)
            ->where('wishList_id', $customer->wishList->wishList_id)
            ->first();
           
            // Remove the wish list item after adding to the cart
            $wishListItem->delete();
           
        }
 

        // Return back and show successful message
        return redirect()->route('getWishList')->with('success', 'All Product successfully added to your cart.');
    }

    public function updated($cart)
    {
        // Calculate subtotal from cart item
        $subtotal = 0;
       
        foreach ($cart->cartItems as $cartItem) {
            $subtotal += $cartItem->productItem->product_price * $cartItem->quantity;
            
        }
       
        // Update the subtotal
        $cart->subtotal = $subtotal;
        $cart->save();
    }


    public function getCurrentCustomer()
    {
        return Customer::where('user_id', auth()->user()->user_id)->first();
    }
 
}

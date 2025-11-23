<?php

// app/Http/Controllers/RatingController.php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function updateRating($product_item_id)
    {
        $product_item = ProductItem::find($product_item_id);
        $customer = $this->getCurrentCustomer();
    
        $orderDetails = OrderDetail::where('product_item_id', $product_item_id)
            ->pluck('order_id')
            ->toArray();
    
    
        $rating = Rating::whereIn('order_id', $orderDetails)
            ->where('customer_id', $customer->user_id)
            ->where('product_item_id', $product_item_id)
            ->latest('created_at') 
            ->first();

    
        // Pass the retrieved data to the view
        return view('rates.rating', compact('product_item', 'rating'));
    }
    
    

    public function updateRatingPost(Request $request ,$rating_id)
    {
        $request->validate([
            'rating_value'      => 'required|integer|min:1|max:5',
            'rating_comment'    => 'nullable|string',
            'rating_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
    
        $rating = Rating::find($rating_id); 

        $rating->rating_value = $request->rating_value;
        $rating->rating_comment = $request->rating_comment;
        $rating->rating_status = 'rate';
        
        if ($request->hasFile('rating_image')) {
           
            $rating->rating_image = $this->upload($request);
        }
       
        $rating->save();
        
        return redirect()->route('order.getStatusOrder',['rating_id' => $rating->rating_id])->with('success', 'Rating updated successfully!');
    }
    

    private function upload(Request $request)
    {
        $request->validate([
            'rating_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('rating_image');

        $imageName = time() . '.' . $request->rating_image->extension();

        $imagePath = $file->storeAs('img', $imageName, 'public');

        return $imagePath;
    }

    private function getCurrentCustomer()
    {
        return Customer::where('user_id', auth()->user()->user_id)->first();
    }

    public function reviewReport()
    {
        $ratings = Rating::all();
        $totalStar = $ratings->sum('rating_value');
        $totalRatings = $ratings->count();
    
        // Avoid division by zero
        $averageStar = ($totalRatings > 0) ? $totalStar / $totalRatings : 0;
    
        return view('report.reviewReport', compact('ratings', 'totalStar', 'averageStar'));
    }
}
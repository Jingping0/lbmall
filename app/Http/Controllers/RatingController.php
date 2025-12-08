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
        // 找到商品
        $product_item = ProductItem::findOrFail($product_item_id);

        // 取得目前登入的 customer（若沒有則回到上一頁）
        $customer = $this->getCurrentCustomer();
        if (! $customer) {
            return redirect()->back()->with('error', 'Please log in to rate this product.');
        }

        // 找出該客戶包含這個 product_item 的最近一筆 order_detail（使用 join，避免 model 關聯缺失）
        $orderDetail = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.order_id')
            ->where('order_details.product_item_id', $product_item_id)
            ->where('orders.customer_id', $customer->user_id)
            ->orderBy('order_details.created_at', 'desc')
            ->select('order_details.*')
            ->first();

        $orderQuantity = $orderDetail ? (int) $orderDetail->quantity : null;

        // 取得該客戶對此商品的 rating（若沒有則傳入空模型）
        $orderIds = OrderDetail::where('product_item_id', $product_item_id)->pluck('order_id')->toArray();

        $rating = Rating::whereIn('order_id', $orderIds)
            ->where('customer_id', $customer->user_id)
            ->where('product_item_id', $product_item_id)
            ->latest('created_at')
            ->first();

        if (! $rating) {
            $rating = new Rating(); // 保證視圖能安全訪問 $rating
        }

        // 在找到 $rating 之后加一个保护
        if ($rating && $rating->rating_status === 'rate') {
            return redirect()->back()->with('error', 'You have already rated this item.');
        }

        // 傳入 orderQuantity 供視圖顯示
        return view('rates.rating', compact('product_item', 'rating', 'orderQuantity'));
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
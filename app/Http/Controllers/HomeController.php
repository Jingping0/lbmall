<?php

namespace App\Http\Controllers;

use App\Models\ProductItem;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularProducts = ProductItem::select('product_item_id','product_name','product_price','product_image','cart_count','click_count')
            ->orderByRaw('(cart_count * 2) + click_count DESC')
            ->take(2)
            ->get();
        return view('home', compact('popularProducts'));

    }
}

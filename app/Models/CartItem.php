<?php

namespace App\Models;

use App\Models\ProductItem;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'product_item_id', 'quantity', 'cart_id'
    ];

    public function productItem()
    {
        return $this->belongsTo(ProductItem::class, 'product_item_id');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

}

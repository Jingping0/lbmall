<?php

namespace App\Models;

use App\Models\ProductItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'quantity',
        'product_item_id'
    ];

    public function productItem()
    {
        return $this->belongsTo(ProductItem::class, 'product_item_id', 'product_item_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
    
}
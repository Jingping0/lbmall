<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'user_id', 'subtotal'
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class,'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductItem::class, 'user_id', 'user_id');
    }

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function productItem()
    {
        return $this->belongsTo(ProductItem::class, 'product_item_id', 'product_item_id');
    }

}

<?php

// app/Models/Rating.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $primaryKey = 'rating_id';

    protected $fillable = [
        'rating_id',
        'order_id',
        'product_item_id',
        'customer_id',
        'rating_value',
        'rating_comment',
        'rating_image',
        'rating_status',
 
    ];

    // Relationships
    public function productItem()
    {
        return $this->belongsTo(ProductItem::class, 'product_item_id', 'product_item_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }


}
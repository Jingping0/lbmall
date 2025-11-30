<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnAndRefund extends Model
{
    use HasFactory;

    protected $table = 'returns';
    protected $primaryKey = 'returnAndRefund_id';

    protected $fillable = [
        
        'order_id',
        'customer_id',
        'reason',
        'description',
        'evidence',
        'comment',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function productItem()
    {
        return $this->hasMany(Product::class, 'product_item_id', 'product_item_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'user_id');
    }
}

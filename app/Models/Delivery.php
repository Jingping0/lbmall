<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    
    protected $primaryKey = 'delivery_id';

    protected $fillable = [
        'delivery_id',
        'order_id',
        'user_id',
        'address_id',
        'username',
        'street',
        'area',
        'postcode',
        'phone',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id');
    }
}


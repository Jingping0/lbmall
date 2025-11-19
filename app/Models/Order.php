<?php

namespace App\Models;

use App\Models\ReturnAndRefund;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'order_id',
        'orderDate',
        'status',
        'subtotal',
        'serviceTax',
        'totalAmount',
        'customer_id',
        'staff_id'        
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'user_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'user_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    public function orderPayment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_id');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'order_id', 'order_id');
    }

    public function updateOrderStatus(Order $order, $status, $staffId)
    {
        $order->status   = $status;
        $order->staff_id = $staffId;
        $order->save();
    }

    //have change returnAndRefunds to returnAndRefund
    public function returnAndRefund()
    {
        return $this->belongsTo(ReturnAndRefund::class, 'order_id', 'order_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class,'order_id', 'order_id');
    }

}
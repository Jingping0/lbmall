<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'transaction_Id',
        'order_id',
        'amount',
        'payment_date',
        'status',
        'payment_method_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentMethod()
    {
        return $this->hasOne(PaymentMethod::class, 'payment_method_id', 'payment_method_id');
    }

    public function updateStatus(string $newStatus)
    {
        $this->status = $newStatus;
        $this->save();
    }
}

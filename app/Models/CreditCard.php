<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_id',
        'payment_method_id',
        'card_holder_name',
        'card_number',
        'expiry_date',
        'cvv',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}


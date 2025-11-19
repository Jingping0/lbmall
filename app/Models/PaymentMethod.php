<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function cash()
    {
        return $this->hasOne(Cash::class);
    }

    public function eWallet()
    {
        return $this->hasOne(EWallet::class);
    }

    public function onlineBanking()
    {
        return $this->hasOne(OnlineBanking::class);
    }

    public function creditCard()
    {
        return $this->hasOne(CreditCard::class);
    }
}
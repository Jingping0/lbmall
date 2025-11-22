<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EWallet extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_id',
        'payment_method_id',
        'platform',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineBanking extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_id',
        'payment_method_id',
        'bank_name',
        'account_number',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
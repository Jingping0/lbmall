<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory;

    protected $table = 'cashes';  //Set the name of the database table

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_id',
        'payment_method_id',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}


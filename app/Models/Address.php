<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $primaryKey = 'address_id';

    protected $fillable = [
        'user_id',
        'username',
        'address_userphone',
        'street',
        'area',
        'postcode',
        'active_flag'
    ];

    public function deliveries()
    {
    return $this->hasMany(Delivery::class);
    }


}
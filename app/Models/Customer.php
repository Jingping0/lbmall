<?php

namespace App\Models;

use App\Models\CustomerService;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;
    protected $table = 'customers';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'username',
        'password',
        'name',
        'email',
        'phone',  
        'userImage',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id', 'user_id');
    }

    public function cart() {
        return $this->hasOne(Cart::class, 'user_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'user_id');
    }

    public function returnAndRefund()
    {
        return $this->hasMany(ReturnAndRefund::class, 'returnAndRefund_id', 'returnAndRefund_id');
    }

    public function wishlist()
    {
        return $this->hasOne(Wishlist::class,'customer_id','user_id');
    }

    public function supportRequests() {
        return $this->hasMany(CustomerService::class, 'cust_service_id', 'cust_service_id');
    }


}
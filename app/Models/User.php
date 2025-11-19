<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'username',
        'password',
        'name',
        'email',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function staff(){
          return $this->hasOne(Staff::class, 'user_id', 'user_id');
    }
    
    public function customer(){
          return $this->hasOne(Customer::class, 'user_id', 'user_id');
    }

    public function newUserId()
    {
        // check if the user is a customer or staff
        if ($this->customer) {
            // get the last customer id
            $lastCustomer = Customer::orderBy('user_id', 'desc')->first();
            $lastCustomerId = $lastCustomer ? $lastCustomer->user_id : 0;
            // increment the id
            $newUserId = $lastCustomerId + 1;
        } elseif ($this->staff) {
            // get the last staff id
            $lastStaff = Staff::orderBy('user_id', 'desc')->first();
            $lastStaffId = $lastStaff ? $lastStaff->user_id : 0;
            // increment the id
            $newUserId = $lastStaffId + 1;
        } else {
            // user is neither staff nor customer
            return null;
        }

        return $newUserId;
    }


}
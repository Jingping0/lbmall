<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Staff extends Model
{
      use HasFactory;
      protected $table = 'staffs';
      protected $primaryKey = 'user_id';
      protected $fillable = [
          'user_id',
          'username',
          'password',
          'name',
          'email',
          'position',
      ];
    
    public function user(){
          return $this->belongsTo(User::class,'user_id', 'user_id');
    }
    
    public function order(){
          return $this->hasOne(Order::class,'user_id', 'user_id');
    }
}
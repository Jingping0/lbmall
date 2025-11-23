<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    use HasFactory;

    protected $primaryKey = 'cust_service_id';
    protected $table = 'customer_service';
    

    protected $fillable = [
        'cust_service_id',
        'customer_id',
        'issue_type',
        'cust_service_desc',
        'cust_service_image',
        'status',
        'comment',      
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'user_id');
    }

}

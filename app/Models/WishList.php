<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    use HasFactory;

    protected $table = 'wishLists';
    protected $primaryKey = 'wishList_id';

    protected $fillable = [
        'wishList_id',
        'customer_id', 
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'user_id');
    }

    // public function productItem()
    // {
    //     return $this->belongsTo(ProductItem::class, 'product_item_id', 'product_item_id');
    // }

    public function wishListItems()
    {
        return $this->belongsToMany(ProductItem::class, 'wish_list_items', 'wishList_id', 'product_item_id');
    }
    

}
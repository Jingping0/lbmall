<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishListItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'product_item_id', 'wishList_id'
    ];


    public function productItem()
    {
        return $this->belongsTo(ProductItem::class, 'product_item_id', 'product_item_id');
    }

    public function wishList()
    {
        return $this->belongsTo(WishList::class, 'wishList_id', 'wishList_id');
    }



}

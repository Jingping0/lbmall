<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    use HasFactory;


    protected $table = 'product_items';
    protected $primaryKey = 'product_item_id';
    protected $foreignKey = 'category_id';

    
    protected $fillable = [
        'product_name', 'product_price', 'product_image','product_desc', 'available', 'product_measurement', 
        'product_subImage1', 'product_subImage2', 'product_subImage3','category_id'
    ];
    // protected $visible = ['product_item_id', 'itemName', 'description', 'price', 'available', 'item_cost', 'category_id'];

    /**
     * Get the category that owns the menu item.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, $this->foreignKey, $this->foreignKey);
    }   
    
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class ,'product_item_id', 'product_item_id');
    }

    public function productItem()
    {
        return $this->belongsToMany(Cart::class, 'cart_items','product_item_id', 'cart_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_item_id');
    }

    public function isAvailable()
    {
        // Check if the menu item is currently available based on some condition
        if ($this->available) {
            return true;
        } else {
            return false;
        }
    }

    public function returnAndRefund()
    {
        return $this->belongsTo(ReturnAndRefund::class, 'returnAndRefund_id', 'returnAndRefund_id');
    }

    public function wishList()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishListItems()
    {
        return $this->belongsToMany(WishList::class, 'wish_list_items', 'product_item_id', 'wishList_id');
    }
    

    public function ratings()
    {
        return $this->hasMany(Rating::class,'product_item_id');
    }

    public function getPopularityScoreAttribute(){
        return ($this->click_count * 1) + ($this->cart_count * 3);
    }

}

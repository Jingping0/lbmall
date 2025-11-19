<?php

namespace App\Models;

use App\Models\ProductItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // Map to the 'categories' table
    protected $table = 'categories';

    // Map the 'category_id' column to the primary key
    protected $primaryKey = 'category_id';

    // Map the 'category_name' and 'category_desc' columns to the fillable array
    protected $fillable = [
        'category_name',
        'category_desc'
    ];

    /**
     * Get the menu items for the category.
     */
    public function productItems()
    {
        return $this->hasMany(ProductItem::class, 'category_id', 'category_id');
    }

    /**
     * Scope a query to eager load the menu items for the category.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithMenuItems($query)
    {
        return $query->with('productItems');
    }
}
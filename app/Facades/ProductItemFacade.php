<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Builders\ProductItemBuilder;
use App\Models\ProductItem;
use Illuminate\Support\Str;


class ProductItemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'productitem';
    }

    public static function getProductItemsByCategory($categoryId)
    {
        return ProductItem::where('category_id', $categoryId)->get();
    }

    public static function createProductItem($name, $description, $price, $category_id, $item_cost)
    {
        //Sanitize the input
        $name = Str::limit(strip_tags($name),255);
        $description = htmlspecialchars($description,ENT_QUOTES);

        // Use the builder to create a menu item
        $productItem = (new ProductItemBuilder())
            ->setItemName($name)
            ->setDescription($description)
            ->setPrice($price)
            ->setCategoryId($category_id)
            ->setAvailable(true) // Set availability as true by default
            ->setItemCost($item_cost)
            ->build();
            
        return $productItem;
    }

    public static function updateProductItem($id, $name, $description, $price, $category_id, $available, $item_cost)
    {
        //Sanitize the input
        $name = Str::limit(strip_tags($name),255);
        $description = htmlspecialchars($description,ENT_QUOTES);

        // Use the builder to update the menu item
        $updatedProductItem = (new ProductItemBuilder())
            ->setItemName($name)
            ->setDescription($description)
            ->setPrice($price)
            ->setCategoryId($category_id)
            ->setAvailable($available)
            ->setItemCost($item_cost)
            ->build();

        $productItem = ProductItem::findOrFail($id);
        $productItem->fill($updatedProductItem->toArray());
        $productItem->save();

        return $updatedProductItem;
    }

    public static function deleteMenuItem($id)
    {
        $productItem = ProductItem::findOrFail($id);
        $productItem->delete();
    }


}

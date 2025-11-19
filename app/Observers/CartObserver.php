<?php

namespace App\Observers;

use App\Models\Cart;

// class CartObserver implements ObserverInterface
// {
//     public function created($cart)
//     {
//         // Handle the cart model when it is created
//     }

//     public function updated($cart)
//     {
//         // Calculate subtotal from cart item
//         $subtotal = 0;
       
//         foreach ($cart->cartItems as $cartItem) {
//             $subtotal += $cartItem->productItem->product_price * $cartItem->quantity;
            
//         }
       
//         // Update the subtotal
//         $cart->subtotal = $subtotal;
//         $cart->save();
//     }

    

//     public function deleted($cart)
//     {
//         // Calculate subtotal from cart item
//         $subtotal = 0;

//         foreach ($cart->cartItems as $cartItem) {
//             $subtotal += $cartItem->productItem->product_price * $cartItem->quantity;
//         }

//         // Update the subtotal
//         $cart->subtotal = $subtotal;
//         $cart->save();
//     }


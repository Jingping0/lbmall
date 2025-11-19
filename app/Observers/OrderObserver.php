<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver implements ObserverInterface
{
    public function created($order)
    {
        // Clear the customer's cart
        $customer = $order->customer;
        $customer->cart->cartItems()->delete();
        $customer->cart->subtotal = 0;
        $customer->cart->save();
    }

    public function updated($order)
    {
        //
    }

    public function deleted($order)
    {
        //
    }
}

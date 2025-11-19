<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\ProductItem;
use App\Observers\CartObserver;
use Illuminate\Routing\Controller;


class CartController extends Controller
{




    public function index()
    {
        $customer = Customer::where('user_id', auth()->user()->user_id)->first();
        
        // Access the user's cart
        $cart = Cart::where('user_id', $customer->user_id)->first();
        $cart-> cartItems;
        return view('cart', compact('cart'));
    }

    public function addProductItem(ProductItem $productItem)
    {
        // Get current customer
        $customer = $this->getCurrentCustomer();

        // Check if the product item already exists in the cart
        $existingCartItem = CartItem::where('cart_id', $customer->cart->cart_id)
            ->where('product_item_id', $productItem->product_item_id)
            ->first();

        if ($existingCartItem) {
            // Update the quantity of the existing cart item
            $existingCartItem->quantity += 1;
            $existingCartItem->save();
        } else {
            // Create a new cart item
            CartItem::create([
                'cart_id'      => $customer->cart->cart_id,
                'product_item_id' => $productItem->product_item_id,
                'quantity'     => 1,
            ]);
        }
        $cart = Cart::find($customer->cart->cart_id);
        $this->updated($cart);

        // Return back and show successful message
        return redirect()->route('product_items.index')->with('success', 'Product successfully added to your cart.');
    }

    public function updateQuantity($requestedProductItemId, $action)
    {
        // Get current customer
        $customer = $this->getCurrentCustomer();

        // Get the cart item
        $cartItem = CartItem::where('product_item_id', $requestedProductItemId)
            ->where('cart_id', $customer->cart->cart_id)
            ->first();

        // Check if cart item exists
        if (!$cartItem) {
            // Return cart view with error message
            return redirect()->route('cart.index')
                ->with('error', 'ERROR. No such Product item in your cart.')
                ->with('customer', $customer);
        }

        // Update cart item quantity based on action
        if ($action === 'increase') {
            if ($cartItem->quantity >= 15) {
                return redirect()->route('cart.index')
                    ->with('error', 'You\'ve reached the maximum quantity (15) for this item.');
            }
            $cartItem->quantity++;

        } elseif ($action === 'decrease') {
            if ($cartItem->quantity <= 1) {
                $this->deleted($cartItem);
                return redirect()->route('cart.index')->with('success', 'Cart item removed.');
            }
            $cartItem->quantity--;
        }
        
        // Save changes to database
        $cartItem->save();

         // Update the Cart model to trigger the observer
        $cart = Cart::find($customer->cart->cart_id);
        $this->updated($cart);

        // Return cart view with success message
        return redirect()->route('cart.index')->with('success', 'Cart item updated.');
    }

    public function removeCartItem($removeCartItem)
    {
        // Get current customer
        $customer = $this->getCurrentCustomer();

        // Delete the requested cart Item
        $cartItem = CartItem::where('product_item_id', $removeCartItem)
            ->where('cart_id', $customer->cart->cart_id)
            ->first();

            $cartItem->delete();
            $cart = Cart::find($customer->cart->cart_id);
            $this->updated($cart);
           

        // If cart item is decreased to 0, prompt that it's removed
        if ($cartItem->quantity === 0) {
            return redirect()->route('cart.index')->with('success', 'Cart item removed.');
        }

        // Redirect to cart page and display success message
        return redirect()->route('cart.index')->with('success', 'Item successfuly removed');
    }

    public function toCheckout()
    {
        // Get current customer
        $customer = $this->getCurrentCustomer();

        $cartItem = $customer->cart->cartItems;

        // Check if cart item exists
        if (!$cartItem) {
            // Return cart view with error message
            return redirect()->route('cart.index')
                ->with('error', 'ERROR. No such Product item in your cart.')
                ->with('customer', $customer);
        }

        return view('checkout', compact('customer'));
    }

    public function getCurrentCustomer()
    {
        return Customer::where('user_id', auth()->user()->user_id)->first();
    }

        public function updated($cart)
    {
        // Calculate subtotal from cart item
        $subtotal = 0;
       
        foreach ($cart->cartItems as $cartItem) {
            $subtotal += $cartItem->productItem->product_price * $cartItem->quantity;
            
        }
       
        // Update the subtotal
        $cart->subtotal = $subtotal;
        $cart->save();
    }

    

    public function deleted($cart)
    {
        // Calculate subtotal from cart item
        $subtotal = 0;

        foreach ($cart->cartItems as $cartItem) {
            $subtotal += $cartItem->productItem->product_price * $cartItem->quantity;
        }

        // Update the subtotal
        $cart->subtotal = $subtotal;
        $cart->save();
    }
}


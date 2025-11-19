<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Mail\OrderReceipt;
use App\Models\ProductItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\{Cash, Order, EWallet, Payment, Customer, CreditCard, Delivery, OrderDetail, ReturnAndRefund};

class PaypalController extends Controller
{
    public function paypal(Request $request)
    {

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            "application_context" => [
                "return_url" => route('success'),
                "cancel_url" => route('cancel')
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'MYR',
                        'value' => $request->price
                    ],
                ],
            ],
        ]);

        
        if(isset($response['id']) && $response['id'] != null){
            foreach($response['links'] as $link){
                if($link['rel'] === 'approve'){
                    return redirect()->away($link['href']);
                }
            }
        }else{
            return redirect()->route('cancel');
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        
        $customer = $this->getCurrentCustomer();

        $lastOrder = Order::orderBy('order_id', 'desc')->first();
        $newOrderId = $lastOrder->order_id + 1; 

        $orderItems = [];
        foreach ($customer->cart->cartItems as $cartItem) {
            $orderItems[] = new OrderDetail([
                'product_item_id' => $cartItem->product_item_id,
                'quantity' => $cartItem->quantity,
                'order_id' => $newOrderId, 
            ]);

            $productItem = ProductItem::find($cartItem->product_item_id);

            if ($productItem) {
                // Subtract ordered quantity from available quantity
                $productItem->available -= $cartItem->quantity;
            
                // Ensure the available quantity doesn't go below zero
                $productItem->available = max(0, $productItem->available);
            
                // Save the updated product item
                $productItem->save();
            }
        }

        // Remove commas from the amount and cast it to a float
        $subtotal = floatval(str_replace(',', '', number_format($customer->cart->subtotal , 2)));
        $totalAmount = floatval(str_replace(',', '',  number_format($customer->cart->subtotal + ($customer->cart->subtotal * 0.06), 2)));
       
        $order = new Order([
            'orderDate' => now(),
            'status'    =>'Preparing',
            'subtotal' => $subtotal,
            'serviceTax' => number_format($customer->cart->subtotal * 0.06, 2),
            'totalAmount' => $totalAmount,
            'customer_id' => $customer->user_id,
            'staff_id' => null,
        ]);    

        $order->save();
        
        $order->orderDetails()->saveMany($orderItems);

        $this->addDelivery($request);

        $this->createPayment($request, $order);

        // $this->createRate($request);

        $payment = Payment::where("order_id",$order->order_id);
        $orderDetail = OrderDetail::where("order_id",$order->order_id);

        Mail::to($order->customer->email)->send(new OrderReceipt($order,$payment,$orderDetail));

       return redirect()->route('order.getStatusOrder')->with('success', 'Your order successfully placed.');
    }

    private function getCurrentCustomer()
    {
        return Customer::where('user_id', auth()->user()->user_id)->first();
    }

    public function addDelivery(Request $request)
    {
        $customer = $this->getCurrentCustomer();

        
        $order = Order::latest()->first();
        $lastDelivery = Delivery::orderBy('delivery_id', 'desc')->first();
        $newDeliveryId = $lastDelivery->delivery_id + 1; 

      
        $activeAddress = $customer->addresses->first(function ($address) {
            return $address->active_flag == 'Y';
        });
    
        $delivery = Delivery::create([
            'delivery_id' => $newDeliveryId,
            'order_id' => $order->order_id,
            'user_id' => $customer->user_id,
            'address_id' => $activeAddress->address_id, // Assuming your address ID column is 'id'
            'username' => $customer->username,
            'street' => $activeAddress->street,
            'area' => $activeAddress->area,
            'postcode' => $activeAddress->postcode,
            'phone' => $activeAddress->address_userphone,
            'status' => 'Collected',
        ]);
    
        $delivery->save();
        
    }

    private function createPayment(Request $request)
    {

        // Get the order just created (last row of record of Order Table)
        $order = Order::latest()->first();

        // Get payment method id
        $paymentMethodId = $this->getPaymentMethodId($request);

        // Remove commas from the amount and cast it to a float
        $amount = floatval(str_replace(',', '', $order->totalAmount));

        // Create new Payment
        $payment = Payment::create([
            'order_id'          => $order->order_id,
            'amount'            => $amount,
            'payment_date'      => now(),
            'status'            => 'Completed',
            'payment_method_id' => 53205,
        ]);

    }

    public function createRate(Request $request)
    {
        $customer = $this->getCurrentCustomer();
    
        $order = Order::latest()->first(); // Assuming you are getting the latest order
        $orderDetails = OrderDetail::where('order_id', $order->order_id)->get(); // Get all order details for the order
    
        foreach ($orderDetails as $orderDetail) {
            $rating = Rating::create([
                'order_id' => $order->order_id,
                'product_item_id' => $orderDetail->product_item_id,
                'customer_id' => $customer->user_id,
                'rating_value' => 0,
                'rating_comment' => '',
                'rating_image' => '',
                'rating_status' => 'unrate'
            ]);
    
            // You can perform any additional logic or validations here if needed
    
            $rating->save();
        }
    
        // You can return a response or redirect after processing all ratings
        return redirect()->back()->with('success', 'Ratings created successfully.');
    }

    private function getPaymentMethodId(Request $request)
    {
        $paymentMethod = $request->input('paymentMethod');

        switch ($paymentMethod) {
            case 'cashOnDelivery':
                return 53201;
            case 'onlineBanking':
                return 53202;
            case 'eWallet':
                return 53203;
            case 'creditCard':
                return 53204;
            case 'paypal':
                return 53205;
            default:
                return false;
        }
    }

    public function cancel()
    {

    }
}

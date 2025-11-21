<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Mail\OrderReceipt;
use App\Models\ProductItem;
use Illuminate\Http\Request;
use App\Models\OnlineBanking;
use App\Observers\OrderObserver;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\{Cash, Order, EWallet, Payment, Customer, CreditCard, Delivery, OrderDetail, ReturnAndRefund};


class OrderController extends Controller
{

    public function __construct()
    {
        Order::observe(OrderObserver::class);
    }

    public function index()
    {
        // QUEST: Get customer order list or process to current order?
        $order = null;
        return view('order', compact('order'));
    }

    public function showOrderList()
    {
        $orders = Order::all();

        return view('admin.orderList', compact('orders'));
    }

    public function editOrder(Request $request)
    {
        $order = Order::find($request->order_id);

        return view('admin.editOrder', compact('order'));
    }

    public function editOrderPost(Request $request, $order_id)
    {

        $request->validate([
            'status' => 'required'
        ]);

        $order = Order::find($order_id);
        $order->staff_id = Auth::user()->user_id;
        $order->status = $request->status;

        $order->save();
        return redirect()->route('admin.editOrder',['order_id' => $order->order_id])->with('success', 'Order updated successfully.');    
    }

    public function getStatusOrder(Request $request)
    {
        $customer = $this->getCurrentCustomer();
        $statusFilter = $request->input('status', 'all');
    
        $query = $customer->orders()->orderByDesc('created_at');
    
        if ($statusFilter !== 'all') {
            $query->whereHas('orderDetails', function ($q) use ($statusFilter) {
                $q->where('status', $statusFilter);
            });
        }
    
        $orders = $query->get();
    
        return view('myPurchase', compact('orders'));
    }

    public function updateOrderStatus($orderId, Request $request)
    {
        // Fetch the order based on the provided order ID
        $order = Order::findOrFail($orderId);

        // Get the action (cancel, complete, etc.) from the request
        $action = $request->input('action');

        // Update the order status based on the action
        if ($action === 'cancel') {

            $order->update(['status' => 'Cancelled']);
            $order->save();
            return redirect()->back()->with('success', 'Order cancelled successfully.');

        } elseif ($action === 'received') {

            $order->update(['status' => 'Completed']);
            $order->save();
            $this->createRate($request);
            
            return redirect()->back()->with('success', 'Order completed successfully.');

        } elseif ($action === 'returnAndRefund') {

            $order->update(['status' => 'returnAndRefund']);
            $order->save();
            return view('returnAndRefund',['order' => $order]);
            
        
        } elseif ($action === 'delivery') {

            $order = Order::find($orderId);
            $delivery = $order->delivery;
            return view('deliveryTracking', ['order' => $order, 'delivery' => $delivery]);
            // $order->update(['status' => 'returnAndRefund']);
            // $order->save();
            // return redirect()->back()->with('success', 'Order Return successfully.');
        } elseif ($action === 'refundDetail') {

            $order = Order::find($orderId);
            $order = Order::with('returnAndRefund')->where('order_id',$orderId)->first();
  
    
            return view('returnDetails', ['order' => $order]);
        }

    }
    


    public function getCustomerOrderList()
    {
        // $customer = Customer::where('user_id', session('user'))->first();
        $customer = $this->getCurrentCustomer();
        $orders = $customer->orders()->orderByDesc('created_at')->get();
        return view('orders ', compact('orders'));
    }

    // public function getOrderHistory()
    // {
    //     // $customer = Customer::where('user_id', session('user'))->first();
    //     $customer = $this->getCurrentCustomer();
    //     $orders = $customer->orders()->orderByDesc('created_at')->get();
    //     return view('myPurchase ', compact('orders'));
    // }

    public function retrieveOrderDetail($orderId)
    {
        // Get customer
        $customer = $this->getCurrentCustomer();

        // Verify that the customer has an order with the requested ID
        $order = $customer->orders->where('order_id', $orderId)->first();
        
        if (!$order) {
            // Return invalid order message
            session()->flash('error', 'Invalid Order');
            return view('orderDetail', compact('order'));
        }

        // Verify that the customer is authorized to access this order
        if ($order->customer_id != $customer->user_id) {
            // Return unauthorized message
            session()->flash('error', 'Unauthorized Access');
            return view('orderDetail', compact('order'));
        }

        // Get order payment detail
        $payment = $order->orderPayment;
        return view('orderDetail', compact('order', 'payment'));
    }


    public function placeOrder(Request $request)
    {
        // Validate form
        if ($this->validateForm($request) === false) {
            return redirect()->route('cart.toCheckout');
        }

        $customer = $this->getCurrentCustomer();

        $lastOrder = Order::orderBy('order_id', 'desc')->first();

        if($lastOrder){
              $newOrderId = $lastOrder->order_id + 1;
        }else{
              $newOrderId = 1;
        }

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

        $payment = Payment::where("order_id",$order->order_id);
        $orderDetail = OrderDetail::where("order_id",$order->order_id);

        // Mail::to('chiangjs-wm20@student.tarc.edu.my')->send(new MyTestMail($data));
        Mail::to($order->customer->email)->send(new OrderReceipt($order,$payment,$orderDetail));


        return redirect()->route('order.getStatusOrder')->with('success', 'Your order successfully placed.');
    }


    public function showPaymentList()
    {
        $payments = Payment::all();

        return view('admin.paymentList', compact('payments'));
    }


    private function validateForm(Request $request)
    {
        $paymentMethod = $request->input('paymentMethod');

        switch ($paymentMethod) {
            case 'cashOnDelivery':
            case 'eWallet':
                return true; 
            case 'creditCard':
                return $this->validateCreditCard($request);
            case 'onlineBanking':
                return $this->validateOnlineBanking($request);
            default:
                return redirect()->back()->withErrors(['paymentMethod' => 'Invalid payment method chosen. Please try again.']);
        }
    }

    private function validateCreditCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cardHolder' => ['required', 'max:255'],
            'cardNumber' => ['required', 'digits:16'],
            'expiryDate' => ['required', 'regex:/^\d{2}\/\d{2}$/'],
            'cvv' => ['required', 'digits_between:3,4'],
        ], [
            'cardHolder.required' => 'Please enter your name as shown on your card.',
            'cardNumber.required' => 'Please enter your card number.',
            'cardNumber.digits' => 'Card number must be 16 digits long.',
            'expiryDate.required' => 'Please enter your card\'s expiry date (MM/YY).',
            'expiryDate.regex' => 'Expiry date must be in format MM/YY.',
            'cvv.required' => 'Please enter your card\'s CVV.',
            'cvv.digits_between' => 'CVV must be 3 or 4 digits long.',
        ]);

        if ($validator->fails()) {
            session()->flash('error', $validator->messages()->first());
            return false;
        }

        return true;
    }

    private function validateOnlineBanking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bankSelect' => ['required'],
            'bankAccountNumber' => ['required', 'numeric'],
        ], [
            'bankSelect.required' => 'Please select a bank',
            'bankAccountNumber.required' => 'Please enter a bank account number',
            'bankAccountNumber.numeric' => 'Bank account number must be numeric',
        ]);

        if ($validator->fails()) {
            session()->flash('error', $validator->messages()->first());
            return false;
        }

        return true;
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

    public function addDelivery(Request $request)
    {
        $customer = $this->getCurrentCustomer();
        
        $order = Order::latest()->first();
        $lastDelivery = Delivery::orderBy('delivery_id', 'desc')->first();

         if($lastDelivery){
              $newDeliveryId = $lastDelivery->delivery_id + 1;
        }else{
              $newDeliveryId = 1;
        }
  
        $delivery = Delivery::create([
            'delivery_id'   => $newDeliveryId,
            'order_id'   => $order->order_id,
            'user_id'    => $customer->user_id,
            'address_id' => $request->address_id,
            'username'   => $customer->username,
            'street'     => $request->street,
            'area'       => $request->area,
            'postcode'   => $request->postcode,
            'phone'      => $request->phone,
            'status'     => 'Collected',
        ]);
        $delivery->save();
        
    }

    // only be accessed within the class 
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
            'payment_method_id' => $paymentMethodId,
        ]);

        // Store to corresponding payment method
        $this->storePaymentMethod($request);
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

    private function storePaymentMethod(Request $request)
    {
        // Get the payment just created (last row of record of Payment Table)
        $payment = Payment::latest()->first();

        switch ($payment->payment_method_id) {
            case 53201:
                Cash::create([
                    'transaction_id'    => $payment->transaction_id,
                    'payment_method_id' => $payment->payment_method_id,
                ]);
                break;
            case 53202:
                OnlineBanking::create([
                    'transaction_id'    => $payment->transaction_id,
                    'payment_method_id' => $payment->payment_method_id,
                    'bank_name'         => $request->input('bankSelect'),
                    'account_number'    => $request->input('bankAccountNumber'),
                ]);
                break;
            case 53203:
                EWallet::create([
                    'transaction_id'    => $payment->transaction_id,
                    'payment_method_id' => $payment->payment_method_id,
                    'platform'          => $request->input('eWalletPlatform'),
                ]);
                break;
            case 53204:
                CreditCard::create([
                    'transaction_id'    => $payment->transaction_id,
                    'payment_method_id' => $payment->payment_method_id,
                    'card_holder_name'  => $request->input('cardHolder'),
                    'card_number'       => $request->input('cardNumber'),
                    'expiry_date'       => $request->input('expiryDate'),
                    'cvv'               => $request->input('cvv'),
                ]);
                break;
            default:
                return false;
        }
    }



    private function getCurrentCustomer()
    {
        return Customer::where('user_id', auth()->user()->user_id)->first();
    }

    public function salesReport()
    {
        $orders = Order::all();
        $totalSales = $orders->sum('totalAmount');
        $totalServiceTax = $orders->sum('serviceTax');
        $totalSubtotal = $orders->sum('subtotal');

        return view('report.salesReport', compact('totalSubtotal','totalServiceTax','totalSales', 'orders'));
    }
    

}
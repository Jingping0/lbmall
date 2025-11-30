<?php

namespace App\Http\Controllers;

use App\Mail\ReturnReply;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\ReturnAndRefund;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class ReturnAndRefundController extends Controller
{
    public function getCustReturnAndRefund($order_id)
    {
        // Retrieve order
        $order = Order::findOrFail($order_id);
    
        // Retrieve order details
        $orderDetails = OrderDetail::where('order_id', $order_id)->get();

        // Pass both the order and its details to the view
        return view('returnAndRefund', compact('order','orderDetails'));
    }

    public function returnAndRefundPost(Request $request)
    {
        $request->validate([
            'reason'        => 'required',
            'description'   => 'required',

        ]);

        

        $order_id = $request->input('order_id');
        
        $order = Order::findOrFail($order_id);

        // Assuming you have a method to get the current customer
        $customer = $this->getCurrentCustomer();

        $evidenceImage = $request->file('evidence')->store('img', 'public');

        $returnAndRefund = new ReturnAndRefund([
            
            'order_id'           =>$order_id,
            'customer_id'        =>$customer->user_id,
            'reason'             =>$request->reason,
            'description'        =>$request->description,
            'evidence'           =>$evidenceImage,
            'status'             =>'pending',
        ]);

        $returnAndRefund->save();

        return redirect()->route('CustReturnAndRefund', $order->order_id)
        ->with('success', 'Return and Refund form has submitted successfully.');

    }

    public function showReturnList()
    {
        $returns = ReturnAndRefund::all();

        return view('admin.returnList',compact('returns'));
    }

    public function editReturn(Request $request)
    {
        $return = ReturnAndRefund::find($request->returnAndRefund_id);

        return view('admin.editReturn', compact('return'));
    }

    public function editReturnPost(Request $request, $returnAndRefund_id)
    {
        $request->validate([
            'reason'        => 'required',
            'description'   => 'required',
            'comment'       => 'required',
            'status'        => 'required',
        ]);

        $return = ReturnAndRefund::find($request->returnAndRefund_id);
        $return->reason = $request->reason;
        $return->description = $request->description;
        $return->comment = $request->comment;
        $return->status = $request->status;

        if($request->hasFile('evidence')){
            Storage::delete('public/' . $return->evidence);

            $return->evidence = $request->file('evidence')->store('img', 'public');
        }

        $return->save();
 
        
        if($request->status == 'approved'){
            Mail::to($return->customer->email)->send(new ReturnReply($return));
        }
        

        return redirect()->route('admin.editReturn',['returnAndRefund_id' => $return->returnAndRefund_id])->with('success', 'Return record updated successfully.');    
        
    }

    public function destroy(string $return)
    {  
        $deleteReturn = ReturnAndRefund::findOrFail($return);
        $deleteReturn->delete();
        
        return redirect()->back()->with('success', 'Refund record Removed successfully');
    }    


    private function getCurrentCustomer()
    {
        return Customer::where('user_id', auth()->user()->user_id)->first();
    }

    public function returnReport()
    {
        $returns = ReturnAndRefund::all();
        $orders = Order::all();
        $totalRefund = $orders->sum('totalAmount');

        return view('report.returnReport', compact('returns','totalRefund','orders'));
    }



}

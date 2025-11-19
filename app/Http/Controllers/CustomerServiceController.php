<?php

namespace App\Http\Controllers;

use App\Mail\ContactReply;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerService;
use Illuminate\Support\Facades\Mail;


class CustomerServiceController extends Controller
{
    public function createRequest(Request $request)
    {
        $customer = $this->getCurrentCustomer();
    
        $request->validate([
            'issue_type'            => 'required',
            'cust_service_desc'     => 'required',
            'cust_service_image'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $lastCustomerService = CustomerService::orderBy('cust_service_id', 'desc')->first();
    
        $cust_service_image = $request->file('cust_service_image')->store('img', 'public');
    
        $customerService = CustomerService::create([
            'cust_service_id'    => $lastCustomerService->cust_service_id + 1,
            'customer_id'        => $customer->user_id,
            'issue_type'         => $request->issue_type,
            'cust_service_desc'  => $request->cust_service_desc,
            'cust_service_image' => $cust_service_image,
            'status'             => 'Open',
            'comment'            => null,
        ]);
    
        return redirect()->route('contact')->with('success', 'Your Request have been sent successfully.');
    }

    public function showCustomerServiceList()
    {
        $requests = CustomerService::all();

        return view('admin.customerServiceList',compact('requests'));
    }
    
    public function editCustomerService(Request $request)
    {
        $request = CustomerService::find($request->cust_service_id);
    
        return view("admin.editCustomerService", compact('request'));
    }    

    public function editCustomerServicePost(Request $request, $cust_service_id)
    {
        $request->validate([
            'status'      => 'required',
            'comment'     => 'required'
        ]);

        $customerService = CustomerService::find($request->cust_service_id);
        $customerService->status = $request->status;
        $customerService->comment = $request->comment;

        $customerService->save();

        
        // Check if the status is "Resolved" before sending the email
        if ($request->status == 'Resolved') {
            Mail::to($customerService->customer->email)->send(new ContactReply($customerService));
        }
        return redirect()->route('contact.editCustomerService',['cust_service_id' => $customerService->cust_service_id])->with('success','Record updated successfully');
     
    }

    private function getCurrentCustomer()
    {
        return Customer::where('user_id', auth()->user()->user_id)->first();
    }
}

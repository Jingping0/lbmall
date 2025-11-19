<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\CustomerRepository;



class CustomerController extends Controller
{

    protected $customerRepository;


    public function __construct(CustomerRepository $customerRepository, )
    {
        $this->customerRepository = $customerRepository;
    }
    
    public function showCustomerList()
    {
        $customers = $this->customerRepository->getAllCustomers();
        return view('admin.customerList', ['customers' => $customers]);
    }


    public function createCustomer()
    {
        return view('admin.createCustomer');
    }

 
    public function createCustomerPost(Request $request)
    {

        //validate the input
        $request->validate([
            'username'  => ['required', 'string'],
            'password'  => ['required','regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
            'name'      => ['required', 'max:255'],
            'email'     => ['required', 'string', 'email', 'unique:users'],
            'phone'     => ['required', 'regex:/^01[0-9]{8}$/'],
            'userImage' => ['file','mimes:jpg,png,jpeg'],  
        ],[
            'password.regex' => 'Minimum eight characters, at least one letter, one number and one special character',
        ]);
       
        // $request->validate([
        //     'username'  => 'required',
        //     'password'  => 'required',
        //     'name'      => 'required',
        //     'email'     => 'required',
        //     'phone'     => 'required',
        //     // 'userImage' => 'required',
        // ]);

        $customerData = [
            'username'  => $request->username,
            'password'  => $request->password,
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            // 'userImage' => $request->userImage,
        ];

        $customer = $this->customerRepository->createCustomer($customerData);

        return redirect()->route('admin.createCustomer')
            ->with('success', 'Customer created successfully.');
    }
    
    public function show($id)
    {
        $customer = $this->customerRepository->findCustomer($id);
    
        return view('customers/customerShow', [
            'customer' => $customer
        ]);
    }



    public function editCustomer($id)
    {
        $customer = $this->customerRepository->findCustomer($id);
    
        return view('admin.editCustomer', ['customer' => $customer]);
    }

    
    public function editCustomerPost(Request $request, $id)
    {
        
        //validate the input
        // $request->validate([
        //     'username'  =>'required',
        //     'password'  =>'required',
        //     'name'      =>'required',
        //     'email'     =>'required',
        //     'phone'     =>'required',
        //     'userImage' => ['required','file','mimes:jpg,png,jpeg'],  
        // ]);
        
        // //validate the input
        $request->validate([
            'username'  => ['required', 'string'],
            'password'  => ['required'],
            'name'      => ['required', 'max:255'],
            'email'     => ['required', 'string', 'email'],
            'phone'     => ['required', 'regex:/^01[0-9]{8}$/'], 
        'userImage' => ['file','mimes:jpg,png,jpeg'],  
        ]);
        
       //call updateCustomer to update custome in the repository
        $customer = $this->customerRepository->updateCustomer($request, $id);     
        
        //hash the password
        $hashedPassword = Hash::make($request->input('password'));
        $request->merge(['password' => $hashedPassword]);

        //redirect to user with friendly message
        return redirect()->route('admin.editCustomer',['user_id' => $customer->user_id])
        ->with('success','Customer Updated successfully.'); 
    }  
    
    public function destroy($id)
    {  
        //call customerRepository to delete the customer
        $this->customerRepository->deleteCustomer($id);
        
        return redirect()->back()->with('success', 'Customer Removed successfully');
    }

    public function customerReport()
    {
        $customers = $this->customerRepository->all();
        $xml = new \DomDocument('1.0', 'UTF-8');
        $customersNode = $xml->createElement('customers');
        foreach ($customers as $customer) {
            $customerNode = $xml->createElement('customer');
            $idNode = $xml->createElement('user_id', $customer['user_id']);
            $customerNode->appendChild($idNode);
            $usernameNode = $xml->createElement('username', $customer['username']);
            $customerNode->appendChild($usernameNode);
            $passwordNode = $xml->createElement('password', $customer['password']);
            $customerNode->appendChild($passwordNode);
            $emailNode = $xml->createElement('email', $customer['email']);
            $customerNode->appendChild($emailNode);
            $phoneNode = $xml->createElement('phone', $customer['phone']);
            $customerNode->appendChild($phoneNode);
            $customersNode->appendChild($customerNode);
        }
        $xml->appendChild($customersNode);
        $xml->formatOutput = true;
        $xmlString = $xml->saveXML();
        file_put_contents(public_path('xml/customerReport.xml'), $xmlString);
    
        $xmlPath = public_path('xml/customerReport.xml');
        $xslPath = public_path('xml/customerReport.xsl');
    
        $xml = new \DOMDocument();
        $xml->load($xmlPath);
        $xml->formatOutput = true;
    
        $xsl = new \DOMDocument();
        $xsl->load($xslPath);
        $xsl->documentElement->setAttribute('xmlns:laravel', 'http://laravel.com/ns');
    
        $proc = new \XSLTProcessor();
        $proc->importStylesheet($xsl);
    
        $html = $proc->transformToXml($xml);
    
        return response($html)->header('Content-type', 'text/html');
    }

    public function customerProfile()
    {
        $customer = $this->customerRepository->getCustomerByUserId(auth()->user()->user_id);
     
        return view('customers/customerProfile', compact('customer'));
    }

    public function profile_home()
    {
        $customer = $this->customerRepository->getCustomerByUserId(auth()->user()->user_id);
    
        return view('profile_home', compact('customer'));
    }

    public function customerProfileEdit()
    {
        $customer = $this->customerRepository->getCustomerByUserId(auth()->user()->user_id);
        return view('customers/customerProfileEdit',compact('customer'));
    }

    public function customerProfileEditPost(Request $request)
    {
        //call the customerRepository to edit the customer Profile
        return $this->customerRepository->updateCustomerProfile($request);    
         
        
    }

    public function changeCustPassword()
    {
        $customers = Customer::all();
        return view('auth/changeCustPassword', ['customers' => $customers]);
    }


    public function changeCustPasswordPost(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
    
        $result = $this->customerRepository->changeCustPassword($request->all(), auth()->user()->user_id);

        if ($result) {
            return redirect()->route('changeCustPassword')->with('message', 'Password Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Current Password does not match with Old Password');
        }
    }

    public function showDeleteAccount()
    {
        return view('auth/deleteAccount');
    }

    public function deleteAccount(Request $request,$id)
    {
        $request->validate([
            'password' => 'required'
        ]);

        // Check if the provided password matches the authenticated user's password
        if (Hash::check($request->password, Auth::user()->password)) {
            // Password is correct, delete the customer and user records
            $this->customerRepository->deleteCustomer($id);
            // You may also want to log the user out
            Auth::logout();

            return redirect()->route('home')->with('success', 'Your account has been deleted.');
        } else {
            // Password is incorrect
            return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
        }
    }
}
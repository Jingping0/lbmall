<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\User;
use App\Models\CartItem;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class CustomerRepository 
{

    protected $model;

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $customer = $this->model->find($id);
        return $customer->update($data);
    }

    public function delete($id)
    {
        $customer = $this->model->find($id);
        return $customer->delete();
    }

    public function getAllCustomers()
    {
        return Customer::all();
    }

    public function findCustomer($id)
    {
        return $this->model->findOrFail($id);
    }

    public function createCustomer(array $data)
    {
        // Get the last customer and staff
        $lastCustomer = Customer::orderBy('user_id', 'desc')->first();

        $user = User::create([
            'user_id'   => $lastCustomer->user_id + 1,
            'username'  => $data['username'],
            'password'  => bcrypt($data['password']),
            'name'      => $data['name'],
            'email'     => $data['email'],
            'role'      => 'customer',
        ]);
    
        $customer = Customer::create([
            'user_id'   => $lastCustomer->user_id + 1,
            'username'  => $data['username'],
            'password'  => bcrypt($data['password']),
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            // 'userImage' => $data['userImage'],
        ]);
    
        // if (isset($data['userImage'])) {
        //     $imagePath = 'storage/'. $customer->userImage;
        //     if (Storage::exists($imagePath)) {
        //         Storage::delete($imagePath);
        //     }
        //     $userImage = $data['userImage']->store('userImage', 'public');
        // }
    
        return $customer;
    }

    public function updateCustomer(Request $request,$id)
    {
        
        //call customer in the database
        $customer = Customer::find($id);
        $customer->username  = $request->username;
        $customer->password  =  Hash::make($request->password);
        $customer->name      = $request->name;
        $customer->email     = $request->email;
        $customer->phone     = $request->phone;
       
        if($request->hasFile('userImage')){
            Storage::delete('public/' . $customer->userImage);

            $customer->userImage = $request->file('userImage')->store('userImage', 'public');
        }

        $customer->save();
           
        // update the user info
        $user = User::find($id);
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->save();
        
        return Customer::find($id);

    }

    public function deleteCustomer(string $customer)
    {
        // Find the cart items associated with the customer
        $cartItems = CartItem::whereHas('cart', function ($query) use ($customer) {
            $query->where('user_id', $customer);
        })->get();
    
        // Delete each cart item
        foreach ($cartItems as $cartItem) {
            $cartItem->delete();
        }
    
        // Delete the cart associated with the customer
        $deleteCart = Cart::where('user_id', $customer)->first();
        if ($deleteCart) {
            $deleteCart->delete();
        }
    
        // Delete the customer information based on the user_id
        $deleteCustomer = Customer::findOrFail($customer);
        $deleteCustomer->delete();
    
        // Delete the user information based on the user_id
        $user = User::where('user_id', $customer)->first();
        $user->delete();
    }
        
    public function getCustomerByUserId($user_id)
    {
        return Customer::where('user_id', $user_id)->first();
    }

    public function updateCustomerProfile(Request $request)
    {        
        // validate user input
        $validatedData = $request->validate([
            'username'  => 'required',
            'name'      => 'required',
            'email'     => 'required|email',
            'phone' => ['required', 'regex:/^01[0-9]{8,9}$/'],
            'userImage' => ['required','file','mimes:jpg,png,jpeg,gif'],  
        ]);

        // // validate user input
        // $request->validate([
        //     'username'  => ['required', 'string'],
        //     'name'      => ['required', 'max:255'],
        //     'email'     => ['required', 'string', 'email', 'unique:users'],
        //     'phone'     => ['required', 'regex:/^01[0-9]{8}$/'],
        //     'userImage' => ['required','file','mimes:jpg,png,jpeg'],  
        // ]);

        // check if the request has profile image
        if ($request->hasFile('userImage')) {
            $imagePath = 'storage/'.auth()->user()->userImage;
            // check whether the image exists in the directory
            if (Storage::exists($imagePath)) {
                // delete image
                Storage::delete($imagePath);
            }
            $userImage = $request->userImage->store('userImage', 'public');  
        }

        // update the user info
        $user = User::where('user_id',session('user_id'))->first(); 
        $user->username = $request->username;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->save();
        
        // update the customer info
        $customer = Customer::where('user_id',session('user_id'))->first();
        $customer->username = $request->username;
        $customer->name     = $request->name;
        $customer->email    = $request->email;
        $customer->phone    = $request->phone;
        if(isset($userImage)) {
            $customer->userImage= $userImage;
        }
        $customer->save();

        return redirect()->route('customerProfile')->with('success', 'Profile updated successfully');
    }
    
    public function changeCustPassword(array $data, int $user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        $customer = Customer::where('user_id', $user_id)->first();
    
        $currentPasswordStatus = Hash::check($data['current_password'], $user->password);
    
        if ($currentPasswordStatus) {
            $user->password = Hash::make($data['password']);
            $customer->password = Hash::make($data['password']);
            $user->save();
            $customer->save();
    
            return true;
        } else {
            return false;
        }
    }
    
}


<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\User;
use App\Models\Staff;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class UserRepository 
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
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
        $user = $this->model->find($id);
        return $user->update($data);
    }

    public function delete($id)
    {
        $user = $this->model->find($id);
        return $user->delete();
    }

    public function getAllUsers()
    {
        return User::all();
    }

    public function findUser($id)
    {
        return $this->model->findOrFail($id);
    }

    public function createUser(array $data)
    {
        // Get the last customer and staff
        $lastStaff = User::where('role', 'staff')->orderBy('user_id', 'desc')->first();
        $lastCust  = User::where('role', 'customer')->orderBy('user_id', 'desc')->first();

        // check if the user role is customer, and create a customer record
        if ($data['role'] === 'customer') {
            // create a new user in the database
            $user = User::create([
                'user_id'    => $lastCust->user_id + 1,
                'username'  => $data['username'],
                'password'  => bcrypt($data['password']),
                'name'      => $data['name'],
                'email'     => $data['email'],
                'role'      => $data['role'],
            ]);

            // create a new customer in the database
            $customer = Customer::create([
                'user_id'    =>  $lastCust->user_id + 1,
                'username'  => $data['username'],
                'password'  => bcrypt($data['password']),
                'name'      => $data['name'],
                'email'     => $data['email'],
            ]);

            return $user;
        } else if ($data['role'] === 'staff') {
            // create a new user in the database
            $user = User::create([
                'user_id'    => $lastStaff->user_id + 1,
                'username'  => $data['username'],
                'password'  => bcrypt($data['password']),
                'name'      => $data['name'],
                'email'     => $data['email'],
                'role'      => $data['role'],
            ]);

            // create a new staff in the database
            $staff = Staff::create([
                'user_id'    => $lastStaff->user_id + 1,
                'username'  => $data['username'],
                'password'  => bcrypt($data['password']),
                'name'      => $data['name'],
                'email'     => $data['email'],
                'position'  =>  'staff',
            ]);

            return $user;
        }
    }

    public function updateUser(Request $request, $id)
    {
        //call user in the database
        $user = User::find($id);
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->role     = $request->role;
        $user->save();
    
        //find customerId and staffId in the database
        $customer = Customer::find($id);
        $staff    = Staff::find($id);
    
        if($customer){
            $customer->username = $request->username;
            $customer->password = Hash::make($request->password);
            $customer->name     = $request->name;
            $customer->email    = $request->email;
            $customer->save();   
        }else{
            $staff->username = $request->username;
            $staff->password =  Hash::make($request->password);
            $staff->name     = $request->name;
            $staff->email    = $request->email;
            $staff->save();   
        }

        return User::find($id);
    }
    
    public function deleteUser(string $id)
    {
        // Get the user by ID
        $user = User::find($id);
    
        if (!$user) {
            // Handle the case where the user is not found
            return; // or throw an exception or return a response, depending on your requirements
        }
    
        // Get the role of the user
        $role = $user->role;
    
        if ($role == 'customer') {
            // Find the cart items associated with the customer
            $cartItems = CartItem::whereHas('cart', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })->get();
    
            // Delete each cart item
            foreach ($cartItems as $cartItem) {
                $cartItem->delete();
            }
    
            // Delete the cart associated with the customer
            $deleteCart = Cart::where('user_id', $user->user_id)->first();
            if ($deleteCart) {
                $deleteCart->delete();
            }
    
            // If the user is a customer, find the corresponding customer record
            $deleteCustomer = Customer::where('user_id', $user->user_id)->first();
            if ($deleteCustomer) {
                $deleteCustomer->delete();
            }
        } elseif ($role == 'staff') {
            // If the user is not a customer, find the corresponding staff record
            $deleteStaff = Staff::where('user_id', $user->user_id)->first();
            if ($deleteStaff) {
                $deleteStaff->delete();
            }
        }
    
        // Finally, delete the user
        $user->delete();
    }
    

    public function registerCustomer(array $userData): bool
    {
        $newUser = new User();
        $newUser->username = $userData['username'];
        $newUser->password = $userData['password'];
        $newUser->name = $userData['name'];
        $newUser->email = $userData['email'];
        $newUser->role = $userData['role'];
        $newUser->user_id = $newUser->newUserId();
        $result = $newUser->save();
    
        if ($result) {
            $newCustomer = new Customer();
            // Use the same user_id generated for the User
            $newCustomer->user_id = $newUser->user_id;
            $newCustomer->username = $userData['username'];
            $newCustomer->password = $userData['password'];
            $newCustomer->name = $userData['name'];
            $newCustomer->email = $userData['email'];
            $newCustomer->save();

        
            $latestCartId = Cart::max('cart_id');
            $newCart = new Cart();
            $newCart->cart_id = $latestCartId + 1;
            $newCart->user_id = $newCustomer->user_id;
            $newCart->subtotal = 0;
            $newCart->save();

            $latestWishListId = WishList::max('wishList_id');
            $newWishList = new WishList();
            $newWishList->wishList_id = $latestWishListId + 1;
            $newWishList->customer_id = $newCustomer->user_id;
            $newWishList->save();

        }
    
        return $result;
    }

   public function resetPassword($email, $token, $password)
   {
       $updatePassword = DB::table('password_resets')
           ->where([
               "email" => $email,
               "token" => $token,
           ])->first();

       if (!$updatePassword) {
           return false; // or throw an exception
       }

       $user = User::where("email", $email)->first();
       $user->password = Hash::make($password);
       $user->save();

       DB::table("password_resets")->where(["email" => $email])->delete();

       return true;
   }
        
}

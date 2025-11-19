<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller; 
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller 
{
    protected $userRepository;


    public function __construct(UserRepository $userRepository, )
    {
        $this->userRepository = $userRepository;
       
    }
    
    
    public function showUserList()
    {   
        $users = $this->userRepository->getAllUsers();
        return view('admin.userList', ['users' => $users]);
        
    }

    public function createUser()
    {
        return view('admin.createUser');
    }

    public function createUserPost(Request $request)
    {
        // validate the input
        // $request->validate([
        //     'username'  => 'required',
        //     'password'  => 'required',
        //     'name'      => 'required',
        //     'email'     => 'required',
        //     'role'      => 'required',
        // ]);

        // // validate the input
        $request->validate([
            'username'  => ['required', 'string', ],
            'password'  => ['required','regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
            'name'      => ['required', 'max:255'],
            'email'     => ['required', 'string', 'email', 'unique:users'],
            'role'      => ['required', 'in:customer,staff'],
        ],[
            'password.regex' => 'Minimum eight characters, at least one letter, one number and one special character',
        ]);

        // Identify their role and create a new user using the repository
        $user = $this->userRepository->createUser($request->all());

        // redirect to user with friendly message
        return redirect()->route('admin.createUser')
            ->with('success', 'User created successfully.');
    }
    

    // public function show($id)
    // {
    //     $user = $this->userRepository->findUser($id);
    
    //     return view('users/userShow', [
    //         'user' => $user
    //     ]);
    // }

    public function editUser($id)
    {
        $user = $this->userRepository->findUser($id);
    
        return view('admin.editUser', ['user' => $user]);
    }


    public function editUserPost(Request $request, $user_id)
    {
        //validate the input
        $request->validate([
            'username'  =>'required',
            'password'  =>'required',
            'name'      =>'required',
            'email'     =>'required',
            'role'      =>'required',
        ]);

        // // validate the input
        // $request->validate([
        //     'username'  => ['required', 'string'],
        //     'password'  => ['required'],
        //     'name'      => ['required', 'max:255'],
        //     'email'     => ['required', 'string', 'email'],
        //     'role'      => ['required', 'in:customer,staff'],
        // ]);
        
        //call updateUser to update user in the repository
        $user = $this->userRepository->updateUser($request, $user_id);        
    
        //hash the password
        $hashedPassword = Hash::make($request->input('password'));
        $request->merge(['password' => $hashedPassword]);

        //redirect to user with friendly message
        return redirect()->route('admin.editUser',['user_id' => $user->user_id])
        ->with('success','User Edited successfully.');
    }
    

    public function destroy($id)
    {
        
        //call deleteUseer to delete user in the repository
        $this->userRepository->deleteUser($id);
        
        return redirect()->back()->with('success', 'User Removed successfully');
    }
    
    
    

    public function login(){
        if(Auth::check()){
            return redirect(route('home'));
        }
        return view('auth/login');
    }

    public function loginPost(Request $request){
        $request->validate([
            'email'     => ['required', 'email'],
            'password'  =>  'required'
        ]);
    
        // $request->validate([
        //     'email'     => ['required', 'string', 'email', 'unique:users'],
        //     'password'  => ['required','regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
        //  ],[
        //      'password.regex' => 'Minimum eight characters, at least one letter, one number and one special character',
        //  ]);
        
        $credentials = $request->only('email','password');
        
        if(Auth::attempt($credentials)){
            // Authentication successful
            
            $user = Auth::user();

            if ($user->role === 'customer') {
                
                // Store the user ID and name in the session
                $request->session()->put('user_id', $user->user_id);
                return redirect()->intended(route('home'))->with("success","Login success");
        
             } elseif ($user->role === 'staff') {
                // Store the user ID and name in the session
                $request->session()->put('user_id', $user->user_id);
                return redirect()->intended(route('dashboard'))->with("success","Login success");
             } else {
                 // The user is neither a Customer nor a Staff member
                 abort(403);
             }
        } 
        else {

            // Authentication failed
            if (User::where('email', $request->email)->exists()) {
                // User exists but password is incorrect
                return redirect(route('login'))->with("error","Invalid password");
            } 
            else {
                // User does not exist
                return redirect(route('login'))->with("error","User does not exist");
            }
        }
    }
    


    
    public function registration(){
        return view('auth/registration');
    }

    public function registrationPost(Request $request,UserRepository $userRepository){

        // $data =  $request->validate([
        //     'username'  => ['required'],
        //     'password'  => ['required'],
        //     'name'      => ['required'],
        //     'email'     => ['required'],
        // ]);

         $data =  $request->validate([
            'username'  => ['required', 'string'],
            'password'  => ['required','regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
            'name'      => ['required', 'min:3','max:255'],
            'email'     => ['required','email','unique:users'],
        ],[
            'password.regex' => 'Minimum eight characters, at least one letter, one number and one special character',
        ]);
         
         $data['password'] = Hash::make($data['password']); // Hash the password
         $data['role'] = 'customer'; // Set the default role to 'customer'
         
         //call respository to register new customer
         $result = $userRepository->registerCustomer($data);    

         if(!$result){
             return redirect(route('registration'))->with("error","Registration failed, try again");
         }
         return redirect(route('login'))->with("success","Registration success,login to access the account");
     }

     function logout(){
        Session::invalidate();
        Session::regenerateToken();
        Auth::logout();
        return redirect(route('login'));
    } 

    function forgetPassword(){
        return view("auth.forget-password");
    }

    function forgetPasswordPost(Request $request){
        $request->validate([
            'email'=>"required|email|exists:users",
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send("emails.forget-password",['token' => $token], function ($message) use ($request){
            $message->to($request->email);
            $message->subject("Reset Password");
        });

        return redirect()->to(route("forget.password"))->with("success","We have send an email to reset password");
    }

    function resetPassword($token){
        return view("auth.new-password",compact('token'));
    }

    public function resetPasswordPost(Request $request, UserRepository $userRepository){
        $request->validate([
            "email" => "required|email|exists:users",
            "password" => "required|string|min:6|confirmed",
            "password_confirmation" => "required"
        ]);

        //call resetPassword function in userRepository
        $result = $userRepository->resetPassword($request->email, $request->token, $request->password);

        if ($result) {
            return redirect()->to(route("login"))->with("success","Password reset success");
        } else {
            return redirect()->to(route("reset.password"))->with("error","Invalid");
        }
    
    }

}

<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function showStaffList()
    {
        $staffs = Staff::all();
        return view('admin.staffList', ['staffs' => $staffs]);

    }

    public function createStaff()
    {
        return view('admin.createStaff');
    }

    public function createStaffPost(Request $request)
    {
        // validate the input
        // $request->validate([
        //     'username'  => 'required',
        //     'password'  => 'required',
        //     'name'      => 'required',
        //     'email'     => 'required',
        //     'position'  => 'required',
        // ]);

        // // validate the input
        $request->validate([
            'username'  => ['required', 'string', ],
            'password'  => ['required','regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
            'name'      => ['required', 'max:255'],
            'email'     => ['required', 'string', 'email', 'unique:users'],
            'position'      => ['required', 'in:admin,staff'],
        ],[
            'password.regex' => 'Minimum eight characters, at least one letter, one number and one special character',
        ]);

        // Get the last customer and staff
        $lastStaff = Staff::orderBy('user_id', 'desc')->first();
 
        $user = User::create([
            'user_id'   => $lastStaff->user_id + 1,
            'username'  => $request->username, 
            'password'  => bcrypt($request->password),
            'name'      => $request->name,
            'email'     => $request->email,    
            'role'      => 'staff',
        ]);
    
        $staff = Staff::create([
            'user_id'   => $lastStaff->user_id + 1,
            'username'  => $request->username, 
            'password'  => bcrypt($request->password),
            'name'      => $request->name,
            'email'     => $request->email, 
            'position'  => $request->position,
        ]);
        return redirect()->route('admin.createStaff')
            ->with('success', 'Staff created successfully.');
    }

    public function editStaff(Request $request)
    {
        $staff = Staff::find($request->user_id);
    
        return view('admin.editStaff', ['staff' => $staff]);
    }

    public function editStaffPost(Request $request, $user_id)
    {
        // validate the input
        $request->validate([
            'username'  => 'required',
            'password'  => 'required',
            'name'      => 'required',
            'email'     => 'required',
            'position'  => 'required',
        ]);

        // // validate the input
        // $request->validate([
        //     'username'  => ['required', 'string', ],
        //     'password'  => ['required','regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
        //     'name'      => ['required', 'max:255'],
        //     'email'     => ['required', 'string', 'email', 'unique:users'],
        //     'position'      => ['required', 'in:admin,staff'],
        // ],[
        //     'password.regex' => 'Minimum eight characters, at least one letter, one number and one special character',
        // ]);

        $staff = Staff::find($user_id);
        $staff->username = $request->username;
        $staff->password = Hash::make($request->password);
        $staff->name     = $request->name;
        $staff->email    = $request->email;
        $staff->position = $request->position;
        $staff->save();

        $user = User::find($user_id);
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->save();

        //hash the password
        $hashedPassword = Hash::make($request->input('password'));
        $request->merge(['password' => $hashedPassword]);
        
        //redirect to user with friendly message
        return redirect()->route('admin.editStaff',['user_id' => $staff->user_id])
        ->with('success','Staff Updated successfully.'); 
    }

    public function destroy(string $staff)
    {  
        $deleteStaff = Staff::findOrFail($staff);
        $deleteStaff->delete();

        // Delete the user information based on the user_id
        $user = User::where('user_id', $staff)->first();
        $user->delete();
        
        return redirect()->back()->with('success', 'Staff Removed successfully');
    }    


    public function staffProfile()
    {
        $user_id = Auth::user()->user_id;
        
        $staff = Staff::where('user_id', $user_id)->first();

        return view('admin.staffProfile', compact('staff'));
    }
}
       
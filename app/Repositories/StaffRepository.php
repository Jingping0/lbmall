<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffRepository implements StaffRepositoryInterface
{
    protected $model;

    public function __construct(Staff $staff)
    {
        $this->model = $staff;
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
        $staff = $this->model->find($id);
        return $staff->update($data);
    }

    public function delete($id)
    {
        $staff = $this->model->find($id);
        return $staff->delete();
    }

    public function getAllStaffs()
    {
        return Staff::all();
    }

    public function findStaff($id)
    {
        return $this->model->findOrFail($id);
    }

    public function createStaff(array $data)
    {
        // Get the last customer and staff
        $lastStaff = Staff::orderBy('user_id', 'desc')->first();

        // create a new user in the database
        $user = User::create([
            'user_id'   => $lastStaff->user_id + 1,
            'username'  => $data['username'],
            'password'  => bcrypt($data['password']),
            'name'      => $data['name'],
            'email'     => $data['email'],
            'role'      => 'staff',
        ]);

        // create a new staff in the database
        $staff = Staff::create([
            'user_id'   => $lastStaff->user_id + 1,
            'username'  => $data['username'],
            'password'  => bcrypt($data['password']),
            'name'      => $data['name'],
            'email'     => $data['email'],
            'position'  => $data['position'],
        ]);

        return $staff;
    }

    public function updateStaff(Request $request, $id)
    {
        // call staff in the database
        $staff = Staff::find($id);
        $staff->username  = $request->username;
        $staff->password  = $request->password;
        $staff->name      = $request->name;
        $staff->email     = $request->email;
        $staff->position  = $request->position;

        $staff->save();

        // call user in the database
        $user = User::find($id);
        $user->username = $request->username;
        $user->password = $request->password;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->save();
    }

    public function deleteStaff($id)
    {
        // Delete the staff information based on the userId
        $staff = Staff::find($id);
        $staff->delete();

        // Delete the user information based on the userId
        $user = User::where('user_id', $id)->first();
        $user->delete();
    }
}

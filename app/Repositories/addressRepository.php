<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository
{
    protected $model;

    public function __construct(Address $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function getAllAddresses()
    {
        return Address::all();
    }

    public function index()
    {
        return Address::all();
    }

    public function create()
    {
        return new Address();
    }

    public function createAddress($addressData)
    {
        $address = Address::create([
            'user_id' => session('user_id'),
            'username' => $addressData['username'],
            'address_userphone' => $addressData['address_userphone'],
            'street' => $addressData['street'],
            'area' => $addressData['area'],
            'postcode' => $addressData['postcode'],
            'active_flag' => 'Y',
        ]);

        // if user add the first address, make default to Y
        $existingAddressesCount = Address::where('user_id', session('user_id'))->count();
        if($existingAddressesCount != 1){
            // This is not the first address added, set default flag to 'N'
            $address->active_flag = 'N';
        }
        $address->save();

        return $address;
    }

    public function edit(Address $address)
    {
        return $address;
    }

    public function update($data, Address $address)
    {
        $address->update([
            'username' => $data['username'],
            'address_userphone' => $data['address_userphone'],
            'street' => $data['street'],
            'area' => $data['area'],
            'postcode' => $data['postcode'],
        ]);

        return $address;
    }

    public function destroy(string $id)
    {
        $address = Address::find($id);
        $address->delete();
    }

    public function setDefault(Address $address)
    {
        $user_id = session('user_id');
        $cusAddresses = Address::where('user_id', $user_id)->get();

        // Set active_flag to 'N' for all addresses of the user except the selected address
        foreach($cusAddresses as $addr){
            if($addr->address_id != $address->address_id){
                $addr->active_flag = 'N';
                $addr->save();
            }
        }

        // Set active_flag to 'Y' for the selected address
        $address->active_flag = 'Y';
        $address->save();

        return $address;
    }

    public function getCustomerAddress()
    {
        $user_id = auth()->user()->user_id;
        return Address::where('user_id', $user_id)->get();
    }
}
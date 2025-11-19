<?php

namespace App\Repositories;

use App\Models\Address;

interface AddressRepositoryInterface
{
    public function all();
    
    public function getAllAddresses();
    
    public function index();
    
    public function create();
    
    public function createAddress($addressData);
    
    public function edit(Address $address);
    
    public function update($data, Address $address);
    
    public function destroy(Address $address);
    
    public function setDefault(Address $address);
    
    public function getCustomerAddress();
}
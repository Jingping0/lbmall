<?php

namespace App\Http\Controllers;
use App\Models\Address;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AddressRepository;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    
    protected $addressRepository;

    public function __construct(AddressRepository $addressRepository, )
    {
        $this->addressRepository = $addressRepository;
    }

    public function index()
    {
        
        $addresses = $this->addressRepository->getAllAddresses();

        return view('addresses.addressList', compact('addresses'));
    }


    public function create()
    {
        return view('customers/cus_addAddress');
    }



    public function store(Request $request)
    {
        $request->validate([
            'username'          => 'required|string|max:255',
            'address_userphone' => ['required', 'regex:/^[0-9]{3}-[0-9]{7,8}/'],
            'street'            => 'required|string|max:255',
            'area'              => 'required|string|max:255',
            'postcode'          => ['required', 'regex:/^[0-9]{5}/']
        ], [
            'username.required'          => 'User name field is required',
            'address_userphone.required' => 'User phone field is required',
            'postcode.regex'             => '5 digit for postcode only',
            'address_userphone.regex'    => 'Please follow the format 12-34567890',
        ]);
    
        $addressData = [
            'user_id'          => session('user_id'),
            'username'         => $request->username,
            'address_userphone'=> $request->address_userphone,
            'street'           => $request->street,
            'area'             => $request->area,
            'postcode'         => $request->postcode,
            'active_flag'      => $request->active_flag,
        ];
    
        $address = $this->addressRepository->createAddress($addressData);
    
        // Redirect the user and send a success message
        return redirect()->route('address.getCustomerAddress')->with('success', 'Address added successfully');
    }

    public function edit(Address $address)
    {
        return view('addresses/editAddress', compact('address'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        // Validation of input
        $validate = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'address_userphone' => ['required', 'regex:/^[0-9]{3}-[0-9]{7,8}/'],
            'street' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'postcode' => ['required', 'regex:/^[0-9]{5}/']
        ], [
            'username.required' => 'User name field is required',
            'address_userphone.required' => 'User phone field is required',
            'postcode.regex' => '5 digits for postcode only',
            'address_userphone.regex' => 'Please follow the format 012-34567890',
        ]);

        if ($validate->fails()) {
            session()->flash('error', $validate->messages()->first());
            return redirect()->route('address.edit', $address->address_id);
        }

        // // Remove the encryption code as it is unnecessary
        // // Hash the Phone number
        // $hashedPhone = encrypt($request->input('address_userphone'));
        // $request->merge(['address_userphone' => $hashedPhone]);

        // Update the address in the database
        $address->update($request->all());

        // Redirect the user and send a success message
        return redirect()->route('address.getCustomerAddress')->with('success', 'Address updated successfully');
    }

    public function staffEdit(Address $address)
    {
        return view('addresses/staffEditAddress', compact('address'));
    }

    public function staffUpdate(Request $request, Address $address)
    {
        //validation the input
        $request->validate([
            'username' => 'required|string|max:100',
            'address_userphone' =>  ['required', 'regex:/^[0-9]{3}-[0-9]{7,8}/'],
            'street' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'postcode' => ['required', 'regex:/^[0-9]{5}/']
        ],[
            'username.required' => 'User name field is required',
            'address_userphone.required' => 'User phone field is required',
            'postcode.regax' => '5 digit for postcode only',
            'address_userphone.regax' => 'please follow format 12-34567890',

        ]);

        // // Remove the encryption code as it is unnecessary
        // // Hash the Phone number
        // $hashedPhone = encrypt($request->input('address_userphone'));
        // $request->merge(['address_userphone' => $hashedPhone]);

        //create a new address in database
        $address->update($request->all());

        //redirect the user and send message
        return redirect()->route('address.index')->with('success', 'Address update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //delete the address
        $this->addressRepository->destroy($id);

        //redirect the  user display success message
        return redirect()->route('address.getCustomerAddress')->with('success', 'Address deleted successfully');
    }

    public function staffDestroy(Address $address)
    {
        //delete the address
        $this->addressRepository->destroy($address);

        //redirect the  user display success message
        return redirect()->route('address.index')->with('success', 'Address deleted successfully');
    }

    public function setDefault(Address $address)
    {
        
        $this->addressRepository->setDefault($address);
        
        // Redirect the user and send success message
        return redirect()->route('address.getCustomerAddress')->with('success', 'Default address updated successfully.');
    }

    public function getCustomerAddress()
    {

        $user_id = auth()->user()->user_id;
        $cusAddresses = $this->addressRepository->getCustomerAddress($user_id);

        return view('customers/cusAddress', compact('cusAddresses'));
    }

    public function addressReport()
    {
        $addresses = $this->addressRepository->all();
        $xml = new \DomDocument('1.0', 'UTF-8');
        $addressesNode = $xml->createElement('addresses');
        foreach ($addresses as $address) {
            $addressNode = $xml->createElement('address');
            $idNode = $xml->createElement('id', $address['address_id']);
            $addressNode->appendChild($idNode);
            $userIdNode = $xml->createElement('user_id', $address['user_id']);
            $addressNode->appendChild($userIdNode);
            $usernameNode = $xml->createElement('username', $address['username']);
            $addressNode->appendChild($usernameNode);
            $phoneNode = $xml->createElement('address_userphone', $address['address_userphone']);
            $addressNode->appendChild($phoneNode);
            $streetNode = $xml->createElement('street', $address['street']);
            $addressNode->appendChild($streetNode);
            $areaNode = $xml->createElement('area', $address['area']);
            $addressNode->appendChild($areaNode);
            $postcodeNode = $xml->createElement('postcode', $address['postcode']);
            $addressNode->appendChild($postcodeNode);
            $activeFlagNode = $xml->createElement('active_flag', $address['active_flag']);
            $addressNode->appendChild($activeFlagNode);
            $addressesNode->appendChild($addressNode);
        }
        $xml->appendChild($addressesNode);
        $xml->formatOutput = true;
        $xmlString = $xml->saveXML();
        file_put_contents(public_path('xml/addressReport.xml'), $xmlString);

        $xmlPath = public_path('xml/addressReport.xml');
        $xslPath = public_path('xml/addressReport.xsl');

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

    public function retrieveCustAddress():\Illuminate\View\View
    {

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Retrieve customer addresses for the authenticated user
        $cusAddresses = Address::where('user_id', $userId)->get();

        return view('customers/cus_address', compact('cusAddresses'));
    }


}
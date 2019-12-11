<?php

namespace App\Http\Controllers\Api;

use App\BillingAddress;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class BillingAddressesController extends Controller
{    
    public function index()
    {
        $user = auth('api')->user();
        $addresses = $user->billingAddresses;
        $address_arr = array();

        foreach($addresses as $address)
        {
            $data['id'] = $address->id;
            $data['fullname'] = $address->fullname;
            $data['contact'] = $address->contact;
            $data['other_notes'] = $address->other_notes;
            $data['building'] = $address->building;
            $data['type'] = strtoupper($address->type);
            $data['is_shipping'] = $address->is_shipping;
            $data['is_billing'] = $address->is_billing;
            $data['post_code'] = $address->postCode();

            array_push($address_arr, $data);
        }

        return $address_arr;
    }

    public function explodedValue($string)
    {
        $data = explode('--',$string);
        return $data;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();
        if(!$request->has('type'))
        {
            $request->request->add(['type' => (string)1]);
        }
        if(!count($user->billingAddresses) > 0)
        {
            $request->request->add(['is_shipping' => true]);
            $request->request->add(['is_billing' => true]);
        }
        try {

            $user->billingAddresses()->create($request->all());
            
            return response()->json(['message' => 'Successfully created!']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'code' => $th->getCode()
            ]);
        }
    }

    public function edit(BillingAddress $address)
    {
        $type_arr = ['HOME' => 1, 'OFFICE' => 2];

        $data['id'] = $address->id;
        $data['fullname'] = $address->fullname;
        $data['contact'] = $address->contact;
        $data['other_notes'] = $address->other_notes;
        $data['building'] = $address->building;
        $data['province'] = $this->explodedValue($address->province);
        $data['city'] = $this->explodedValue($address->city);
        $data['brgy'] = $this->explodedValue($address->brgy);
        $data['type'] = $type_arr[strtoupper($address->type)];
        $data['shipping'] = $address->is_shipping;
        $data['billing'] = $address->is_billing;
        
        return $data;
    }
    /**
     * Update billing address
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response json
     */

    public function update(Request $request)
    {
        $user = auth('api')->user();
        try {
            
            $user->billingAddresses()->where('id', $request->address_id)
            ->update($request->except('address_id'));

            return response()->json(['message' => 'success']);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'code' => $th->getCode()
            ]);
        }
    }
    
    public function displayDefaultAddress()
    {
        $user = auth('api')->user();
        if(count($user->billingAddresses) > 0)
        {
            $shipping = $user->billingAddresses()->where('is_shipping', true)->first();
            $billing = $user->billingAddresses()->where('is_billing', true)->first();
            $data['shipping_id'] = $shipping->id;
            $data['shipping_name'] = $shipping->fullname;
            $data['s_post_code'] = $shipping->AddressDetails;
            $data['billing_name'] = $billing->fullname;
            $data['b_post_code'] = $shipping->AddressDetails;
            $data['contact'] = $shipping->contact;
            $data['b_contact'] = $billing->contact;
            $data['email'] = $user->email;

            return $data;
        }
        return null;
    }

    /**
     * Set a User's default Address
     * @param BillingAddress $address
     * @return \Illuminate\Http\Response json
     */

    public function defaultAddress(Request $request, BillingAddress $address)
    {
        try {
            if($request->billing)
            {
                $address->updateBillingToDefault();
            }
            if($request->shipping)
            {
                $address->updateShippingToDefault();
            }
            return response()->json(['message' => 'Successfully Updated!']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'code'  => $th->getCode()
                ]);
        }
    }
    /**
     * Delete User not default address
     * @param BillingAddress $address
     * @return \Illuminate\Http\Response json
     */

    public function destroooooooy(BillingAddress $address)
    {
        if(!$address->is_shipping && !$address->is_billing)
        {
            $address->delete();
            return response()->json(['message' => 'Successfully Deleted!']);
        }
        return response()->json(['error' => 'Cannot delete default address!']);
    }
}

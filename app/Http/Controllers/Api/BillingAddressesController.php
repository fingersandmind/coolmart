<?php

namespace App\Http\Controllers\Api;

use App\BillingAddress;
use App\Http\Controllers\Controller;
// use App\Http\Requests\BillingAddressRequest;
use Illuminate\Http\Request;
use App\User;

class BillingAddressesController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        if(!$request->has('type'))
        {
            $request->request->add(['type' => (string)1]);
        }
        
        try {
            $user->billingAddresses()->updateOrCreate(
                ['user_id' => $user->id],
                $request->all()
            );
            return response()->json(['message' => 'Successfully updated!']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'code' => $th->getCode()
            ]);
        }
    }
}

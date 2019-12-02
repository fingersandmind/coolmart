<?php

namespace App\Traits;

use App\User;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;

trait PaymentPayPalTrait
{
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function payment($items, $total, $user)
    {
        $data = [];
        $data['items'] = $items;
  
        $data['invoice_id'] = rand(10000,99999).'-'.$user;
        $id = explode('-',$data['invoice_id']);
        $data['invoice_description'] = "Order #{$id[0]} Invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] = $total;

        $provider = new ExpressCheckout;
  
        $response = $provider->setExpressCheckout($data);
  
        $response = $provider->setExpressCheckout($data, true);
        
        return redirect($response['paypal_link']);

    }
   
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        return response()->json(['message' => 'Your payment is cancelled! You can still pay it later!']);
    }
  
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);
  
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            $userId = explode('-',$response['INVNUM']);
            $user = User::findOrFail($userId[1]);
            $user->checkout();

            return response()->json(['Payment was successful']);
        }
  
        dd('Something is wrong.');
    }
}
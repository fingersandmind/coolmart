<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;

class PayPalController extends Controller
{
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        $authId = $request->authId ?? 2;
        $order_item = $this->orderItems($authId);

        $data = [];
        $data['items'] = $order_item;
  
        $data['invoice_id'] = rand(5,6);
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] = $this->total($authId);
  
        $provider = new ExpressCheckout;
  
        $response = $provider->setExpressCheckout($data);
  
        $response = $provider->setExpressCheckout($data, true);
  
        return redirect($response['paypal_link']);
    }

    public function orderItems($id)
    {
        $user = User::findOrFail($id);
        $carts = $user->carts;
        $items = [];
        if($carts)
        {
            foreach($carts as $cart)
            {
                if(!$cart->validMaxQty() == 0)
                {
                    $item['name'] = $cart->item->name;
                    $item['price'] = $cart->cartTotal();
                    $item['desc'] = 'Aircon Unit';
                    $item['qty'] = $cart->validMaxQty();

                    array_push($items, $item);
                }
            }
        }

        return $items;
    }

    public function total($id)
    {
        $user = User::findOrFail($id);
        $total = 0;
        if($user->carts)
        {
            foreach($user->carts as $cart)
            {
                $total += $cart->cartTotal();
            }
        }

        return $total;
    }
   
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        // dd('Your payment is canceled. You can create cancel page here.');

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
            dd('Your payment was successfully. You can create success page here.');
        }
  
        dd('Something is wrong.');
    }
}

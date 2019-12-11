<?php

namespace App\Traits;

use App\Cart;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Srmklive\PayPal\Services\ExpressCheckout;

trait PaymentPayPalTrait
{
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function payment($items, $total, $invoice)
    {
        $data = [];
        $data['items'] = $items;
  
        $data['invoice_id'] = $invoice;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] = $total;

        $provider = new ExpressCheckout;
  
        $response = $provider->setExpressCheckout($data);
  
        $response = $provider->setExpressCheckout($data, true);
        
        return $response;

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
            $tran_id = explode('--', $response['INVNUM']);
            $transaction = Transaction::findOrFail($tran_id[1]);
            $transaction->carts()->update(['status' => Cart::PROCESSING]);

            return redirect(env('PAYMENT_SUCCESS_REDIRECT_LINK').'/'.$transaction->id);
        }
  
        dd('Something is wrong.');
    }
}
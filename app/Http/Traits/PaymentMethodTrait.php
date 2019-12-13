<?php

namespace App\Http\Traits;

trait PaymentMethodTrait
{
    public function paymentCod($transaction)
    {
        $transaction->successfullyCheckedout();

        return redirect(env('PAYMENT_SUCCESS_REDIRECT_LINK').'/'.$transaction->id);
    }
}
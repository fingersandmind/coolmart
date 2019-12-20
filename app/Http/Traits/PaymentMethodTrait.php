<?php

namespace App\Http\Traits;

trait PaymentMethodTrait
{
    public function paymentCod($transaction, $method)
    {
        $transaction->successfullyCheckedout($method);

        return response()->json([
            'transaction_id' => $transaction->id,
        ]);
    }
}
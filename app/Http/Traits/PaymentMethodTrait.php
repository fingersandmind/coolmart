<?php

namespace App\Http\Traits;

trait PaymentMethodTrait
{
    public function paymentCod($transaction)
    {
        $transaction->successfullyCheckedout();

        return response()->json([
            'transaction_id' => $transaction->id,
        ]);
    }
}
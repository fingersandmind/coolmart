<?php

namespace App\Http\Traits;

use App\Cart;
use App\Http\Resources\Transactions\TransactionsResource;

trait ItemReturnedTrait
{
    public function myreturns()
    {
        $user = auth('api')->user();

        $transactions = $user->transactions()
            ->with(['carts' => function($q){
                $q->whereIn('status',[Cart::RETURNED, Cart::REFUNDED, Cart::REPLACED]);
            }])
            ->orderBy('updated_at', 'DESC')
            ->get()
            ->filter(function($q){
                return $q->carts()->whereIn('status',[Cart::RETURNED, Cart::REFUNDED, Cart::REPLACED])->count() > 0;
            });

        return new TransactionsResource($transactions->paginate(5));
    }
}
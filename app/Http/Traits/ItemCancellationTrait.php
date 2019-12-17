<?php

namespace App\Http\Traits;

use App\Cart;
use App\Http\Resources\Transactions\TransactionsResource;
use App\Transaction;
use Illuminate\Support\Facades\DB;

trait ItemCancellationTrait
{
    public function cancellations()
    {
        $user = auth('api')->user();
        $transactions = Transaction::where('user_id', $user->id)
            ->with(['carts' => function($q){
                $q->whereStatus(Cart::CANCELLED);
            }])
            ->orderBy('updated_at', 'DESC')
            ->get()
            ->filter(function($q){
                return $q->carts()->where('status', Cart::CANCELLED)->count() > 0;
            });

        return new TransactionsResource($transactions->paginate(5));
    }
    
    public function cancel(Cart $cart)
    {
        $user = auth('api')->user();
        try {
            if($cart->cancellable())
            {
                DB::beginTransaction();
    
                $cart->update(['status' => Cart::CANCELLED]);
                $user->cancellations()->create([
                    'cart_id' => $cart->id,
                    'reason' => request()->reason,
                    'optional' => request()->optional ?? ''
                ]);
                DB::commit();
                return response()->json(['message' => 'Item successfully cancelled. Thank you!']);
            }
            return response()->json(['message' => 'Sorry! Item is no longer valid for cancellations!']);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => $th->getMessage(),
                'code' => $th->getCode()
            ]);
        }

        return response()->json(['message' => 'Item cancelled successfully!']);
    }
}
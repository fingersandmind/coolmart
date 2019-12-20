<?php

namespace App\Http\Traits;

use App\Cart;
use App\Http\Resources\Transactions\TransactionsResource;
use App\Notifications\OrderCancelled;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait ItemCancellationTrait
{
    protected $notification_delay;

    public function __construct()
    {
        $this->notification_delay = Carbon::now()->addSeconds(5);
    }
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
                $cart->item()->update(['qty' => $cart->item->qty + $cart->qty]);
                DB::commit();

                $itemPrice = number_format($cart->item->accuratePrice(),2);
                $user->notify((new OrderCancelled($user->name, $cart->transaction->TransactionCode, $cart, $itemPrice))->delay($this->notification_delay));

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
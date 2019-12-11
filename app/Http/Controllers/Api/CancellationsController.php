<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\Carts\CartResource;
use App\Http\Resources\Carts\CartsResource;
use Illuminate\Support\Facades\DB;

class CancellationsController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();
        $carts = $user->carts()->where('status', Cart::CANCELLED)->get();

        return new CartsResource($carts);
    }

    public function show(Cart $cart)
    {
        CartResource::withoutWrapping();
        return new CartResource($cart);
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

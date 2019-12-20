<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transactions\TransactionsResource;
use App\Http\Resources\Carts\CartResource;
use App\Http\Traits\ItemCancellationTrait;
use App\Http\Traits\ItemReturnedTrait;
use App\Http\Traits\TransactionTrait;
use App\Cart;
use App\Transaction;

class TransactionController extends Controller
{
    use ItemCancellationTrait, TransactionTrait, ItemReturnedTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('api')->user();

        $transactions = $user->transactions()
        ->with('carts')
        ->orderBy('created_at', 'DESC')
        ->paginate(5);
        
        return new TransactionsResource($transactions);
    }

    /**
     * Show cart preview before checking out an item.
     */
    public function show(Transaction $transaction)
    {
        $carts = $transaction->carts;
        return response()->json([
            'item_count' => $transaction->countCartByQty(Cart::PROCESSING),
            'sub_total' => number_format($transaction->subTotal,2),
            'method' => $transaction->paymentMethod(),
            'address' => $this->addresses($transaction), //See TransactionTrait to find this method
            'items' => $this->items($carts->unique('item_id')), //See TransactionTrait to find this method
        ]);
    }

    /**
     * Display or view Cart whether cancelled, refunded, returned etc..
     */
    public function display(Cart $cart)
    {
        CartResource::withoutWrapping();
        return new CartResource($cart);
    }

    public function store()
    {
        $user = auth('api')->user();
        
        return $user->makeTransaction(); 
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transactions\TransactionsResource;
use App\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('api')->user();

        $transactions = $user->transactions()->with('carts')->paginate(5);
        
        return new TransactionsResource($transactions);
    }

    public function show(Transaction $transaction)
    {
        return response()->json([
            'transaction_id' => $transaction->id,
            'order_id' => $transaction->TransactionCode,
            'item_count' => $transaction->countCartByQty(),
            'sub_total' => number_format($transaction->subTotal(),2),
            'ship_post_code' => explode('--',$transaction->ship_post_code),
            'bill_post_code' => explode('--',$transaction->bill_post_code),
            'date_placed' => $transaction->created_at->toDayDateTimeString(),
            'items' => $this->items($transaction->carts->unique('item_id')),
        ]);
    }

    public function items($carts)
    {
        $items = array();
        foreach($carts as $cart)
        {
            $item['cart_id'] = $cart->id;
            $item['name'] = $cart->item->name;
            $item['slug'] = $cart->item->slug;
            $item['images'] = $cart->item->images->pluck('thumbnail');
            $item['price'] = number_format($cart->item->accuratePrice(),2);
            $item['qty'] = $cart->validMaxQty();
            $item['status'] = $cart->status;
            $item['cancellable'] = $cart->cancellable();
            array_push($items, $item);
        }
        return $items;
    }

    public function store()
    {
        $user = auth('api')->user();
        
        return $user->makeTransaction(); 
    }
}

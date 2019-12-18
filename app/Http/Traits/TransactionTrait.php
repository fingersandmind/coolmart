<?php

namespace App\Http\Traits;

use App\Cart;
use App\Transaction;

trait TransactionTrait
{
    public function cancelled(Transaction $transaction)
    {
        $carts = $transaction->carts()->whereStatus(Cart::CANCELLED)->get();
        return response()->json([
            'item_count' => $transaction->countCartByQty(Cart::CANCELLED),
            'sub_total' => number_format($transaction->subTotal(Cart::CANCELLED),2),
            'address' => $this->addresses($transaction),
            'items' => $this->items($carts->unique('item_id')),
        ]);
    }

    public function pending(Transaction $transaction)
    {
        $carts = $transaction->carts()->whereStatus(Cart::PENDING)->get();
        return response()->json([
            'item_count' => $transaction->countCartByQty(Cart::PENDING),
            'sub_total' => number_format($transaction->subTotal(Cart::PENDING),2),
            'address' => $this->addresses($transaction),
            'items' => $this->items($carts->unique('item_id')),
        ]);
    }

    public function returned(Transaction $transaction)
    {
        $carts = $transaction->carts()->whereStatus(Cart::RETURNED)->get();
        return response()->json([
            'item_count' => $transaction->countCartByQty(Cart::RETURNED),
            'sub_total' => number_format($transaction->subTotal(Cart::RETURNED),2),
            'address' => $this->addresses($transaction),
            'items' => $this->items($carts->unique('item_id')),
        ]);
    }

    public function addresses($transaction)
    {
        $address['status'] = $transaction->status();
        $address['transaction_id'] = $transaction->id;
        $address['order_id'] = $transaction->TransactionCode;
        $address['ship_post_code'] = explode('--',$transaction->ship_post_code);
        $address['bill_post_code'] = explode('--',$transaction->bill_post_code);
        $address['date_placed'] = $transaction->created_at->toDayDateTimeString();

        return $address;
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
            $item['qty'] = $cart->qty;
            $item['status'] = $cart->status;
            $item['cancellable'] = $cart->cancellable();
            $item['returnable'] = $cart->returnable();
            $item['services'] = $cart->getServiceDetails();
            array_push($items, $item);
        }
        return $items;
    }
}
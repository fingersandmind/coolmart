<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Item;
use App\Traits\PaymentPayPalTrait;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
    use PaymentPayPalTrait;

    /**
     * Function to prepare the User's Cart before processing the Paypal Payment.
     * @param User $id
     */

    public function prepare()
    {
        $user = auth('api')->user();
        $transaction = $user->transactions()
            ->where('id', request()->transaction_id)
            ->with(['carts' => function($q){
                $q->whereStatus(Cart::PENDING);
            }])
            ->first();

        $invoice = $transaction->TransactionCode.'--'.$transaction->id;

        $items = $this->items($transaction->carts);
        $total = $this->totalAmount($transaction->carts);

        if(count($items) > 0)
        {
            return $this->payment($items,$total, $invoice);
        }

        return response()->json(['No Items selected']);
    }


    /**
     * Function that gets user uncheckedout Cart
     * @param UsersUncheckedOutCarts
     * @return Array $carts
     */

    public function items($carts)
    {
        $items = [];
        if($carts)
        {
            foreach($carts as $cart)
            {
                if(!$cart->validMaxQty() == 0)
                {
                    $item['name'] = $cart->item->name;
                    $item['price'] = $cart->item->accuratePrice();
                    $item['desc'] = 'Aircon Unit';
                    $item['qty'] = $cart->validMaxQty();

                    array_push($items, $item);
                }
            }
        }

        return $items;
    }

    /**
     * Function to compute all of the uncheckedout Carts
     * already compute if it's discounted or not and qty of per cart
     * @param UsersUncheckedOutCarts
     * @return $total
     */

    public function totalAmount($carts)
    {
        $total = 0;
        if($carts)
        {
            foreach($carts as $cart)
            {
                if(!$cart->validMaxQty() == 0)/** This condition checks if the qty of Item that has been added to cart has still have a valid Qty */
                {
                    $total += $cart->cartTotal();
                }
            }
        }

        return $total;
    }
}

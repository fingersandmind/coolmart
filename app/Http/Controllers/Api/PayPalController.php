<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Item;
use App\Traits\PaymentPayPalTrait;
use App\User;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
    use PaymentPayPalTrait;

    public function prepare(Request $request)
    {
        $request->validate([
            'user' => 'required'
        ]);
        $user = User::with(['carts' => function($q){
            $q->where('is_checkedout', false);
        }])
        ->findOrFail($request->user);

        $items = $this->items($user);
        $total = $this->totalAmount($user);

        if(count($items) > 0)
        {
            return $this->payment($items,$total, $user->id);
        }

        return response()->json(['No Items selected']);
    }

    public function items($user)
    {
        $carts = $user->carts;
        
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

    public function totalAmount($user)
    {
        $carts = $user->carts;

        $total = 0;
        if($user->carts)
        {
            foreach($carts as $cart)
            {
                if(!$cart->validMaxQty() == 0)
                {
                    $total += $cart->cartTotal();
                }
            }
        }

        return $total;
    }
}

<?php

namespace App;

use App\Notifications\OrderProcess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $fillable = ['user_id','ship_post_code', 'bill_post_code', 'subTotal', 'item_count', 'payment_method'];
    protected $paymentMethodString = [
        'cod' => 'Cash On Delivery',
        'paypal' => 'Paypal'
    ];

    public function getTransactionCodeAttribute()
    {
        return str_pad($this->id+1000, 8,'0',STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        $data = $this->carts()->whereIn('status', [Cart::PENDING])->count();

        return $data > 0 ? true : false;
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function paymentMethod()
    {
        if($this->payment_method)
        {
            return $this->paymentMethodString[$this->payment_method];
        }
        return null;
    }

    public function subTotalUncheckedoutCarts()
    {
        $total = 0;
        $carts = $this->carts()->whereStatus(Cart::PENDING)->get();
        if($carts)
        {
            foreach($carts as $cart)
            {
                $total += $cart->cartTotal() + $cart->getServiceTotal();
            }
        }
        return $total;
    }

    public function successfullyCheckedout($method = null)
    {
        try {
            DB::beginTransaction();
            $this->update(['subTotal' => $this->subTotalUncheckedoutCarts(), 'payment_method' => $method]);
            $this->carts()->update(['status' => Cart::PROCESSING]);

            foreach($this->carts as $cart)
            {
                $qty = $cart->item->qty - $cart->validMaxQty();
                $cart->item()->update(['qty' => $qty]);
            }
            DB::commit();
            $this->user->notify(new OrderProcess($this->user->name, $this->TransactionCode, $this->paymentMethodString[$method]));
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => $th->getMessage(),
                'code' => $th->getCode()
            ]);
        }
    }

    public function subTotal($status = 0)
    {
        $total = 0;
        if($status){
            foreach($this->carts()->whereStatus($status)->get() as $cart){
                $total += $cart->checkedoutSubTotal() + $cart->getServiceTotal();
            }
            return $total;
        }
        foreach($this->carts as $cart)
        {
            $total += $cart->cartTotal();
        }
        return $total;
    }

    public function countCartByQty($status = 0)
    {
        $total_count = 0;
        if($status){
            foreach($this->carts()->whereStatus($status)->get() as $cart){
                $total_count += $cart->qty;
            }
            return $total_count;
        }
        foreach($this->carts as $cart)
        {
            $total_count += $cart->validMaxQty();
        }
        return $total_count;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id','ship_post_code', 'bill_post_code'];

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

    public function subTotal($status = 0)
    {
        $total = 0;
        if($status){
            foreach($this->carts()->whereStatus($status)->get() as $cart){
                $total += $cart->cartTotal();
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
                $total_count += $cart->validMaxQty();
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

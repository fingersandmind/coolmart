<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function subTotal()
    {
        $total = 0;
        foreach($this->carts as $cart)
        {
            $total += $cart->cartTotal();
        }
        return $total;
    }

    public function countCartByQty()
    {
        $total_count = 0;
        foreach($this->carts as $cart)
        {
            $total_count += $cart->validMaxQty();
        }
        return $total_count;
    }
}

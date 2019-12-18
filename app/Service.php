<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'cart_id', 'value', 'additional_value'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}

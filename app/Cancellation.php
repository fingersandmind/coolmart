<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cancellation extends Model
{
    protected $fillable = ['user_id', 'cart_id', 'reason', 'optional'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    
}

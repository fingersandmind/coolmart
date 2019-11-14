<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['item_id', 'qty', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Maximum cart qty must not exceed item qty
     * If cart qty is over item qty, item qty must return
     * 
     */

    public function validMaxQty($cartQty)
    {
        return $cartQty > $this->item->qty ? $this->item->qty : $cartQty;
    }
    
}

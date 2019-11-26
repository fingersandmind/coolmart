<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['item_id', 'qty', 'user_id', 'transaction_id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function scopeCheckedout($query)
    {
        return $query->where('is_checkedout', true);
    }

    /**
     * Maximum cart qty must not exceed item qty
     * If cart qty is over item qty, item qty must return
     * 
     */

    public function validMaxQty()
    {
        return $this->qty > $this->item->qty ? $this->item->qty : $this->qty;
    }

    public function cartTotal()
    {
        $total =  $this->item->accuratePrice() * $this->validMaxQty();
        return $total;
    }
    
}

<?php

namespace App\PurchaseOrder;

use App\AirconList;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['item_id', 'purchase_id', 'qty'];
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function item()
    {
        return $this->belongsTo(AirconList::class);
    }

    public function totalAmount()
    {
        return $this->item->net * $this->qty;
    }
}

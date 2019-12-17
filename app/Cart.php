<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['item_id', 'qty', 'user_id', 'transaction_id', 'status'];
    const PROCESSING = 1;
    const SHIPPED = 2;
    const DELIVERED = 3;
    const PENDING = 4;
    const CANCELLED = 5;
    const REFUNDED = 6;
    const RETURNED = 7;
    const REPLACED = 8;

    protected $statusArr = [
        'Processing' => self::PROCESSING, 'Shipped' => self::SHIPPED, 'Delivered' => self::DELIVERED,
        'Pending' => self::PENDING, 'Cancelled' => self::CANCELLED, 'Refunded' => self::REFUNDED,
        'Returned' => self::RETURNED,'Replaced' => self::REFUNDED
    ];

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

    public function cancellations()
    {
        return $this->hasMany(Cancellation::class);
    }

    public function scopeCheckedout($query)
    {
        return $query->where('is_checkedout', true);
    }

    public function scopeUnCheckedout($query)
    {
        return $query->where('is_checkedout', false);
    }

    public function cancellable()
    {
        $date_placed = Carbon::parse($this->created_at);
        $is_cancellable = in_array($this->statusArr[$this->status], [self::PENDING, self::PROCESSING]);
        $is_over =  $this->created_at < $date_placed->addDay() ? true : false;

        if($is_cancellable AND $is_over)
        {
            return true;
        }
        return false;
    }

    public function returnable()
    {
        $date_placed = Carbon::parse($this->updated_at);
        $is_returnable = $this->statusArr[$this->status] == self::DELIVERED ? true : false;
        $is_over =  $this->updated_at < $date_placed->addWeek() ? true : false;

        if($is_returnable AND $is_over)
        {
            return true;
        }
        return false;
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

    public function checkedoutSubTotal()
    {
        return $this->item->accuratePrice() * $this->qty;
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    protected $fillable = ['name','discountable_id', 'discountable_type', 'type', 'percent_off', 'amount'];


    public function discountable()
    {
        return $this->morphTo();
    }
}

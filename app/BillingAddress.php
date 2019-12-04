<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    protected $table = 'billing_addresses';

    protected $fillable = ['user_id', 'fullname', 'contact', 'other_notes', 'building', 'province', 'city', 'brgy', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

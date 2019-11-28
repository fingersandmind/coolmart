<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'stars', 'comments', 'reviewable_id', 'reviewable_type'];

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function starRatePercent()
    {
        return $this->stars * 20;
    }
}

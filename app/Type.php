<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['name', 'description'];
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}

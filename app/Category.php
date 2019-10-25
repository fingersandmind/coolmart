<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

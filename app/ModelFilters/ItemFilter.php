<?php namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ItemFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function name($name)
    {
        return $this->whereLike('name', $name);
    }

    public function sort($type)
    {
        return $this->orderBy('srp', $type);
    }

    public function brand($brands)
    {
        return $this->whereIn('brand_id', $brands);
    }

    public function category($categories)
    {
        return $this->whereIn('category_id', $categories);
    }

    public function type($type)
    {
        return $this->whereIn('type_id', $type);
    }

    public function max($price)
    {
        return $this->where('srp', '<=', $price);
    }
    public function min($price)
    {
        return $this->where('srp', '>=', $price);
    }
}

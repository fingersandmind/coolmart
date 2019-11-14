<?php namespace App\ModelFilters;

use App\Brand;
use App\Category;
use App\Type;
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

    /**
     * Since idk how to filter items by its brand name
     * I come up with this approach of searching the brand name
     * and pluck its ID to its NAME and query the brand_id 
     * with the given name. ^^
     */
    public function brandsArr()
    {
        $arr = [];
        $brands = Brand::pluck('name', 'id');
        foreach($brands as $key => $value)
        {
            $arr[$value] = $key;
        }
        return $arr;
    }

    public function categoryArr()
    {
        $arr = [];
        $categories = Category::pluck('name', 'id');
        foreach($categories as $key => $value)
        {
            $arr[$value] = $key;
        }
        return $arr;
    }
    public function typeArr()
    {
        $arr = [];
        $types = Type::pluck('name','id');
        foreach($types as $key => $value)
        {
            $arr[$value] = $key;
        }
        return $arr;
    }

    public function name($name)
    {
        return $this->whereLike('name', $name)
        ->orWhere('brand_id', $this->brandsArr()[strtoupper($name)] ?? '')
        ->orWhere('category_id', $this->categoryArr()[strtoupper($name)] ?? '')
        ->orWhere('type_id', $this->typeArr()[strtoupper($name)] ?? '');
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

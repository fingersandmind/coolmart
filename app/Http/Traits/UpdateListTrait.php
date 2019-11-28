<?php
namespace App\Traits;

use App\AirconList;
use App\Brand;
use App\Category;
use App\Item;
use App\Type;

trait UpdateListTrait
{
    public function responseData()
    {
        $url = env('AIRCON_API_LIST');
        $response = json_decode(file_get_contents($url));
        return $response;
    }

    public function pluckedModel($model)
    {
        $arr = [];
        foreach($model as $key => $value)
        {
            $arr[$value] = $key;
        }

        return $arr;
    }

    public function types()
    {
        $types = Type::pluck('name','id');
        return $this->pluckedModel($types);
    }

    public function brands()
    {
        $brands = Brand::pluck('name','id');
        return $this->pluckedModel($brands);
    }

    public function loadBrand()
    {
        foreach($this->responseData() as $data)
        {
            if(!Brand::where('name',$data->brand)->exists())
            {
                $name = $data->brand;
                Brand::create([
                    'name' => $name,
                    'slug' => str_slug($name),
                    'description' => $name,
                    'logo' => $name.'.jpg',
                ]);
            }
        }
    }

    public function loadList()
    {
        foreach($this->responseData() as $data)
        {
            
            if(!AirconList::where('model', $data->model)->exists())
            {
                AirconList::create([
                    'brand_id' => $this->brands()[$data->brand],
                    'type'  => $data->type,
                    'model' => $data->model,
                    'description' =>$data->description.' '.$data->cap,
                    'net' => floatval(str_replace(',','',$data->cost)),
                ]);
            }
        }
    }

    public function loadCategory()
    {
        foreach($this->responseData() as $data)
        {          
            $name = $data->type == 'WINDOW' || $data->type == 'SPLIT' ? 'INDOOR' : 'OUTDOOR';
            if(!Category::where('name', $name)->exists())
            {
                Category::create([
                    'name' => $name,
                    'slug' => str_slug($name),
                    'description' => strtolower($name)
                ]);
            }
        }
    }

    public function loadType()
    {
        foreach($this->responseData() as $data)
        {
            if(!Type::where('name',$data->type)->exists())
            {
                $name = $data->type;
                Type::create([
                    'name' => $name,
                    'description' => $name,
                ]);
            }
        }
    }

    public function loadItem()
    {
        foreach($this->responseData() as $data)
        {
            if(!Item::where('name',$data->model)->exists())
            {
                $item = Item::create([
                    'brand_id' => $this->brands()[$data->brand],
                    'type_id' => $this->types()[$data->type],
                    'category_id' => $data->type == 'SPLIT' ||  $data->type == 'WINDOW' ? 1 : 2,
                    'name' => $data->model,
                    'slug' => str_slug($data->model),
                    'description' => $data->description,
                    'srp' => floatval(str_replace(',','',$data->srp)),
                    'cost' => floatval(str_replace(',','',$data->cost)),
                    'qty' => 0
                ]);

                $item->details()->create(['name' => 'Brand Name', 'description' => $data->brand]);
            }
        }
    }
}
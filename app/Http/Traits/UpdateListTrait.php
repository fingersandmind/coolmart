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
            $name = $data->brand;
            Brand::updateOrCreate(
                ['name' => $name],
                [
                    'name' => $name,
                    'slug' => str_slug($name),
                    'description' => $name,
                    'logo' => $name.'.jpg',
                ]
            );
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
    
    /**
     * Function that returns Standard Installation Fee for Items based on type and cooling capacity [TR]
     */
    public function standardInstallFeeTR($tr, $type)
    {
        if(in_array($tr , range(1,2, 1)) AND strpos($type,'CEILING') !== false)
        {
            return 14000;
        }
        if(in_array($tr , range(3,4, 1)) AND strpos($type,'CEILING') !== false)
        {
            return 16000;
        }
        if($tr >=5 AND strpos($type, 'CEILING') !== false)
        {
            return 18000;
        }
    }

    /**
     * Function that returns Standard Installation Fee for Items based on type and cooling capacity [HP]
     */
    public function standardInstallFeeHP($hp, $type)
    {
        if(in_array($hp , range(1,1.5, 0.10)) AND strpos($type,'WALL') !== false)
        {
            return 7500;
        }
        if(in_array($hp , range(2,2.5, 0.10)) AND strpos($type,'WALL') !== false)
        {
            return 9500;
        }
        if(in_array($hp , range(3,4, 0.10)) AND strpos($type,'FLOOR') !== false)
        {
            return 14000;
        }
    }

    public function loadItem()
    {
        foreach($this->responseData() as $data)
        {
            $name = $data->brand . ' ' . $data->model;

            $data1 = floatval(str_replace(['HP', 'TR'], '' ,$data->cap)); //removes TR or HP in capacity e,g 1.5HP becomes 1.5
            $hp_capacity = strpos($data->cap,'TR') ? 0 : number_format($data1,2);
            $tr_capacity = strpos($data->cap,'TR') ? number_format($data1,2) : 0;

            $standard_installation_fee = strpos($data->cap,'TR') ? $this->standardInstallFeeTR($data1, $data->type) : $this->standardInstallFeeHP($data1, $data->type);


            $item = Item::updateOrCreate(
                ['name' => $name],
                [
                    'brand_id' => $this->brands()[$data->brand],
                    'type_id' => $this->types()[$data->type],
                    'category_id' => $data->type == 'SPLIT' ||  $data->type == 'WINDOW' ? 1 : 2,
                    'name' => $name,
                    'slug' => str_slug($data->model),
                    'description' => $data->description,
                    'cap_hp' => $hp_capacity,
                    'cap_tr' => $tr_capacity,
                    'standard_install_fee' => $standard_installation_fee,
                    'srp' => floatval(str_replace(',','',$data->srp)),
                    'cost' => floatval(str_replace(',','',$data->cost)),
                    'qty' => env('APP_ENV') == 'production' ? 0 : 5,
                ]);
            
            $this->itemDetails($item, $data);
        }
    }

    public function itemDetails($item,$data)
    {
        $nameArr = [1 => 'Brand Name', 2 => 'Capacity', 3 => 'Type', 4 => 'Description'];
        $descArr = [1 => $data->brand, 2 => $data->cap, 3 => $data->type, 4 => $data->description];

        for($i = 1; $i <= 4; $i++)
        {
            $item->details()->updateOrCreate(
                ['name' => $nameArr[$i], 'description' => $descArr[$i]],
                ['name' => $nameArr[$i], 'description' => $descArr[$i]]
            );
        }
    }
}
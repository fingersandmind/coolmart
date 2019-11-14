<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AirconList;
use App\Brand;
use App\Category;
use App\Item;
use App\PurchaseOrder\Purchase;
use App\User;
use App\Type;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brandCount = Brand::count();
        $itemCount = Item::count();
        $userCount = User::count();
        $pos = Purchase::get();
        return view('pages.index', compact('brandCount', 'itemCount', 'userCount', 'pos'));
    }
    
    public function loadAll()
    {
        $this->loadList();
        sleep(2);
        $this->loadBrand();
        sleep(1);
        $this->loadType();
        sleep(1);
        $this->loadCategory();
        sleep(1);
        $this->loadItem();

        return response()->json(['success' => 'Data loaded successfully!'], 200);
    }

    public function types()
    {
        $types = Type::pluck('name','id');

        $types_arr = [];
        foreach($types as $key => $value)
        {
            $types_arr[$value] = $key;
        }

        return $types_arr;
    }
    public function brands()
    {
        $brands = Brand::pluck('name','id');

        $brands_arr = [];
        foreach($brands as $key => $value)
        {
            $brands_arr[$value] = $key;
        }

        return $brands_arr;
    }
    

    public function responseData()
    {
        $url = env('AIRCON_API_LIST');
        $response = json_decode(file_get_contents($url));
        return $response;
    }

    public function loadList()
    {

        foreach($this->responseData() as $data)
        {
            
            if(!AirconList::where('model', $data->model)->exists())
            {
                AirconList::create([
                    'brand_id' => $this->brands[$data->brand],
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
                Item::create([
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
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

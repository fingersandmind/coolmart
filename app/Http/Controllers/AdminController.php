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
            
            if(!AirconList::where('model', $data->MODEL)->exists())
            {
                AirconList::create([
                    'brand_id' => $this->brands[$data->BRAND_NAME],
                    'type'  => $data->TYPE,
                    'model' => $data->MODEL,
                    'description' =>$data->MODEL. ' '. $data->DESCRIPTION.' '.$data->CAP,
                    'net' => floatval(str_replace(',','',$data->NET_COST)),
                ]);
            }
        }
    }

    public function loadCategory()
    {
        foreach($this->responseData() as $data)
        {          
            $name = $data->TYPE == 'WINDOW' || $data->TYPE == 'SPLIT' ? 'INDOOR' : 'OUTDOOR';
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
            if(!Brand::where('name',$data->BRAND_NAME)->exists())
            {
                $name = $data->BRAND_NAME;
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
            if(!Type::where('name',$data->TYPE)->exists())
            {
                $name = $data->TYPE;
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
            if(!Item::where('name',$data->MODEL)->exists())
            {
                Item::create([
                    'brand_id' => $this->brands()[$data->BRAND_NAME],
                    'type_id' => $this->types()[$data->TYPE],
                    'category_id' => $data->TYPE == 'SPLIT' ||  $data->TYPE == 'WINDOW' ? 1 : 2,
                    'name' => $data->MODEL,
                    'slug' => str_slug($data->MODEL),
                    'description' => $data->DESCRIPTION,
                    'srp' => floatval(str_replace(',','',$data->SRP)),
                    'cost' => floatval(str_replace(',','',$data->NET_COST)),
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

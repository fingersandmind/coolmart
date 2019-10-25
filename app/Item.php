<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UploadTrait;

class Item extends Model
{
    use UploadTrait;
    protected $fillable = ['brand_id', 'type_id', 'category_id', 'name', 'slug', 'description', 'srp', 'cost', 'qty'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';   
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    

    public function persists($request)
    {
        $img_arr = [];

        if($request->has('image'))
        {
            $file = $request->file('image');
            $filename = $request->slug.'_'.time();
            $folder = 'uploads/model/';
            $imageFilepath = $folder.'image/'.$filename.'.'.$file->getClientOriginalExtension();
            $thumbnailFilepath = $folder.'thumbnail/'.$filename.'.'.$file->getClientOriginalExtension();
            
            $this->uploadImage($this,$file,$folder,'public', $filename, $thumbnailFilepath);
            array_push($img_arr, ['image' => $imageFilepath]);
            array_push($img_arr, ['thumbnail' => $thumbnailFilepath]);
        }

        $this->updateOrCreate(
            ['id' => $this->id],
            [
                'brand_id'      => $request->brand,
                'type_id'       => $request->type,
                'category_id'   => $request->category,
                'description'   => $request->description,
                'name'          => $request->name,
                'slug'          => $request->slug,
                'srp'           => $request->srp,
                'cost'          => $request->cost,
                'qty'           => $request->qty
            ],
        )->image()->updateOrCreate(
            ['imageable_id' => $this->id],
            array_merge(
                $img_arr[0] ?? [], 
                $img_arr[1] ?? []
            )
        );

    }
    
    public function deleteImage()
    {
        $this->checkImage($this->logo, $this);
    }
}

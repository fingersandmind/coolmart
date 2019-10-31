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

    public function details()
    {
        return $this->belongsToMany(Detail::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';   
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    
    /**
     * function to persist item to create or update 
     *
     * 
     * 
     */
    public function persists($request)
    {
        $item = $this->updateOrCreate(
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
        );
        //calls function to upload images
        $this->upload($item,$request);

        $this->persistsDetails($item,$request);
    }
    
    public function deleteImage()
    {
        if($this->images)
        {
            foreach($this->images as $image)
            {
                $this->checkImage($image->image, $this);
                $this->checkImage($image->thumbnail, $this);
            }
        }
    }

    public function upload($item, $request)
    {
        $images_urls = [];
        if($request->has('images'))
        {
            $img_arr = [];
            foreach($request->images as $image)
            {
                $file = $image;
                $filename = str_random(5).'_'.time();
                $folder = 'uploads/model/';
                $imageFilepath = $folder.'image/'.$filename.'.'.$file->getClientOriginalExtension();
                $thumbnailFilepath = $folder.'thumbnail/'.$filename.'.'.$file->getClientOriginalExtension();
                
                $this->uploadImage($this,$file,$folder,'public', $filename, $thumbnailFilepath);
                $img_arr['image'] = ['image' => $imageFilepath];
                $img_arr['thumbnail'] = ['thumbnail' => $thumbnailFilepath];
                array_push($images_urls,$img_arr);
            }
            if($request->method() == 'PUT' || $request->method() == 'PATCH')
            {
                $this->images()->delete();
                $this->deleteImage();
            }
        }
        foreach($images_urls as $url)
        {
            $item->images()->create(
                array_merge(
                    $url['image'] ?? [],
                    $url['thumbnail'] ?? []
                )
            );
        }

    }

    //Many to many relationship persists to create or update via $requests method

    public function persistsDetails($item, $request)
    {
        if($request->method() == 'POST')
        {
            foreach(array_combine($request->names, $request->descriptions) as $name => $desc)
            {
                $item->details()->create(['name'=>$name, 'description' => $desc]);
            }
        }elseif($request->method() == 'PUT' || $request->method() == 'PATCH')
        {
            $item->details()->delete();
            foreach(array_combine($request->names, $request->descriptions) as $name => $desc)
            {
                $item->details()->create(['name'=>$name, 'description' => $desc]);
            }
        }
        
    }
}

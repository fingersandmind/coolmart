<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UploadTrait;

class Brand extends Model
{
    use UploadTrait;
    protected $fillable = ['name', 'slug', 'description', 'logo', 'is_featured'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function lists()
    {
        return $this->hasMany(AirconList::class);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function featureBrand()
    {
        Brand::whereNotIn('id', [$this->id])->update(['is_featured' => false]);
        $this->update(['is_featured' => !$this->is_featured]);
    }


    public function persists($request)
    {
        $img_arr = [];

        if($request->has('logo'))
        {
            $file = $request->file('logo');
            $filename = $request->slug.'_'.time();
            $folder = 'uploads/brand/logo/';
            $filepath = $folder.$filename.'.'.$file->getClientOriginalExtension();
            
            $this->uploadLogo($this,$file,$folder,'public', $filename);
            array_push($img_arr, ['logo' => $filepath]);
        }

        $this->updateOrCreate(
            ['id' => $this->id],
            array_merge(
                [
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'description' => $request->description
                ],
                $img_arr[0] ?? []
            )
        );
    }

    //Only calls it in destroy function to delete existing image in storage if model is deleted!
    public function deleteImage()
    {
        $this->checkImage($this->logo, $this);
    }
    
}

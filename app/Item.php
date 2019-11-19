<?php

namespace App;

use App\ModelFilters\ItemFilter;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UploadTrait;
use EloquentFilter\Filterable;

class Item extends Model
{
    use UploadTrait, Filterable;

    public function modelFilter()
    {
        return $this->provideFilter(ItemFilter::class);
    }
    protected $fillable = ['brand_id', 'type_id', 'category_id', 'name', 'slug', 'description', 'srp', 'cost', 'qty', 'is_featured'];

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

    public function getItemCodeAttribute()
    {
        return str_pad($this->id, 6,'0', STR_PAD_LEFT);
    }

    public function scopeQtyLessThanFive($query)
    {
        return $query->where('qty', '<', 5);
    }

        /**
     * Can have multiple images using polymorphic relations
     */

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function discount()
    {
        return $this->morphOne(Discount::class, 'discountable');
    }

    public function featureItem()
    {
        $this->update(['is_featured' => !$this->is_featured]);
    }

    /**
     * Function to check if a User can review or comment 
     * to an Item in frontend if the User purchased the item.
     * @return boolean $purchased
     */
    public function isPurchasedByAuth()
    {
        $user = auth()->user();
        $purchased = 0;
        if($user)
        {
            if(!$user->carts)
            {
                return $purchased;
            }else{
                foreach($user->carts as $cart)
                {
                    if($cart->item == $this && $cart->is_checkedout == true)
                    {
                        $purchased = 1;
                    }
                }
            }
        }else{
            // return $purchased;
            return 'not authenticated!';
        }
        return $purchased;
    }

    /**
     * @return TypeOfDiscount and the value, if none, @return null.
     */
    public function discountType()
    {
        $type = '';
        if($this->discount)
        {
            $type = $this->discount->type == 'cash_off' ? $this->discount->amount.' OFF' : $this->discount->percent_off.'% OFF';
        }

        return $this->discount ? $type : null;
    }

    /**
     * @return discountedPrice if has discount : originalPrice
     */
    public function accuratePrice()
    {
        $price = 0;
        if($this->discount)
        {
            if($this->discount->type == 'cash_off')
            {
                $price = $this->srp - $this->discount->amount;
            }elseif($this->discount->type == 'percentage')
            {
                $discount = ($this->discount->percent_off / 100) * $this->srp;
                $price = $this->srp - $discount;
            }
        }

        return $this->discount ? $price : $this->srp;
    }
    
    /**
     * function to persist item to create or update 
     * @param   Request $request
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
    /**
     * upload or update multiple Images using Trait
     */

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
                
                $this->uploadImages($this,$file,$folder,'public', $filename, $thumbnailFilepath);
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

    /**
     * @param App/Item $item
     * @param Request $request
     * 
     */

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

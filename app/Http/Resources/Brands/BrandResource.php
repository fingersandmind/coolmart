<?php

namespace App\Http\Resources\Brands;

use App\Http\Resources\ModelsRelationships\BrandsRelationships;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type'  =>  'brands',
            'id'    =>  (string)$this->id,
            'attributes' => [
                'name'  => $this->name,
                'slug'  => $this->slug,
                'description'   => $this->description,
                'logo'  => $this->logo,
            ],
            'relationships' => new BrandsRelationships($this),
            'links' => [
                'self' => url('api/brands',$this->slug)
            ]
        ];
    }
}

<?php

namespace App\Http\Resources\ModelsRelationships;

use App\Http\Resources\Brands\BrandResource;
use App\Http\Resources\Details\DetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemsRelationship extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'details' => [
                'data' => DetailResource::collection($this->details)
            ],
            'brand' => [
                'name' => $this->brand->name,
                'logo' => $this->brand->logo
            ]
        ];
    }
}

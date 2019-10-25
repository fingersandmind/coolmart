<?php

namespace App\Http\Resources\Brands;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Brands\BrandResource;

class BrandsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'data' => BrandResource::collection($this->collection)
        ];
    }

    public function with($request)
    {
        return [
            'links'    => [
                'self' => url('/api/brands'),
            ],
        ];
    }
}

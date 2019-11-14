<?php

namespace App\Http\Resources\Details;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Details\DetailResource;

class DetailsResource extends ResourceCollection
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
            'data' => DetailResource::collection($this->collection)
        ];
    }
}

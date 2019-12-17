<?php

namespace App\Http\Resources\Reviews;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Reviews\ReviewResource;

class ReviewsResource extends ResourceCollection
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
            'data' => ReviewResource::collection($this->collection)
        ];
    }
}

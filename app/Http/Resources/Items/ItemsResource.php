<?php

namespace App\Http\Resources\Items;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemsResource extends ResourceCollection
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
            'data' => ItemResource::collection($this->collection)
        ];
    }
}

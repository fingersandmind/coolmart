<?php

namespace App\Http\Resources\ModelsRelationships;

use App\Http\Resources\Items\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandsRelationships extends JsonResource
{
    /**
     * Create a relationship of a Model.
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'items' => [
                'data' => ItemResource::collection($this->items)
            ]
        ];
    }
}

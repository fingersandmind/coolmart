<?php

namespace App\Http\Resources\ModelsRelationships;

use App\Http\Resources\Items\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandsRelationships extends JsonResource
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
            'models' => [
                'data' => ItemResource::collection($this->items)
            ]
        ];
    }
}

<?php

namespace App\Http\Resources\Types;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TypesResource extends ResourceCollection
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
            'data' => TypeResource::collection($this->collection)
        ];
    }

    public function with($request)
    {
        return [
            'links'    => [
                'self' => url('/api/types'),
            ],
        ];
    }
}

<?php

namespace App\Http\Resources\Carts;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Carts\CartResource;

class CartsResource extends ResourceCollection
{
    
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => CartResource::collection($this->collection)
        ];
    }

    public function with($request)
    {
        return [
            'with' => [
                'count' => $this->sum('qty'),
            ],
        ];
    }
}

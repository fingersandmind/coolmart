<?php

namespace App\Http\Resources\ModelsRelationships;

use App\Http\Resources\Carts\CartResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionsRelationship extends JsonResource
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
            'carts' => [
                'data' => CartResource::collection($this->carts)
            ]
        ];
    }
}

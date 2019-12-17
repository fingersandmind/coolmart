<?php

namespace App\Http\Resources\Categories;


use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Categories\CategoryResource;

class CategoriesResource extends ResourceCollection
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
            'data' => CategoryResource::collection($this->collection)
        ];
    }
}

<?php

namespace App\Http\Resources\Categories;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'type'  => 'categories',
            'id'    =>  (string)$this->id,
            'attributes' => [
                'name'  =>  $this->name,
                'slug'  =>  $this->slug,
                'description' => $this->description,
            ]
        ];
    }
}

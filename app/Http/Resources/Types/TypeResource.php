<?php

namespace App\Http\Resources\Types;

use App\Http\Resources\ModelsRelationships\TypesRelationships;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
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
            'type'  => 'types',
            'id'    =>  (string)$this->id,
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
            ],
            'relationships' => new TypesRelationships($this),
            'links' => [
                'self' => url('/api/types',$this->id)
            ]
        ];
    }
}

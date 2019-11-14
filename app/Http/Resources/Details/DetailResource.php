<?php

namespace App\Http\Resources\Details;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailResource extends JsonResource
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
            'type'  => 'details',
            'id'    => (string)$this->id,
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
            ],
            'links' => [
                'self' => url('api/details', $this->id)
            ]
        ];
    }
}

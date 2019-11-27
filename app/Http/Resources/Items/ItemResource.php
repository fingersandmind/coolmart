<?php

namespace App\Http\Resources\Items;

use App\Http\Resources\ModelsRelationships\ItemsRelationship;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'type'  => 'items',
            'id'    => (string)$this->id,
            'attributes' => [
                'name'  => $this->name,
                'slug'  => $this->slug,
                'description'   => $this->description,
                'images' => $this->images->pluck('image'),
                'thumbnails' => $this->images->pluck('thumbnail'),
                'discountedSrp'   => number_format($this->accuratePrice()),
                'srp'   => number_format($this->srp),
                'discountType' => $this->discountType(),
                'qty'   => (string)$this->qty,
                'brand_id'  => (string)$this->brand_id,
                'type_id'  => (string)$this->type_id,
                'category_id' => (string)$this->category_id,
                'isPurchasedByAuth' => $this->isPurchasedByAuth(),
                'ratings' => (string)$this->ratings()
            ],
            'relationships' => new ItemsRelationship($this),
            'links' => [
                'self' => url('/api/items',$this->slug)
            ]
        ];
    }
}

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
                'cap_hp' => number_format($this->cap_hp,2),
                'cap_tr' => number_format($this->cap_tr,2),
                'discountType' => $this->discountType(),
                'qty'   => (string)$this->qty,
                'brand_id'  => (string)$this->brand_id,
                'type_id'  => (string)$this->type_id,
                'category_id' => (string)$this->category_id,
                'ratings' => (string)$this->ratings(),
                'star_percent_rate' => (string)$this->starRatePercent(),
                'total_reviewer' => (string)count($this->reviews),
                'standard_installation_fee' => $this->standard_install_fee,
            ],
            'relationships' => new ItemsRelationship($this), //This is the related model resource
            'links' => [
                'self' => url('/api/items',$this->slug)
            ]
        ];
    }
}

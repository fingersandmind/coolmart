<?php

namespace App\Http\Resources\Carts;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'type'  => 'carts',
            'id'    =>  (string)$this->id,
            'is_checkedout' => $this->is_checkedout,
            'attributes' => [
                'item_id'       => (string)$this->item_id,
                'item_slug'     => $this->item->slug,
                'item_name'     => $this->item->name,
                'item_images'   => $this->item->images->pluck('thumbnail'),
                'item_qty'      => $this->item->qty,
                'item_srp'      => number_format($this->item->srp, 2),
                'item_discountedSrp' => number_format($this->item->accuratePrice(), 2),
                'discountType' => $this->item->discountType(),
                'cart_qty'      => $this->qty,
                'validQty'      => $this->validMaxQty(),
                'subtotal_per_item'     => $this->item->accuratePrice() * $this->qty,
                'date_placed' => $this->created_at->toDayDateTimeString(),
                'status' => $this->status,
                'cancellable' => $this->cancellable()
            ]
        ];
    }
}

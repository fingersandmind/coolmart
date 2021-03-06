<?php

namespace App\Http\Resources\Transactions;

use App\Cart;
use App\Http\Resources\ModelsRelationships\TransactionsRelationship;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'type'  =>  'transactions',
            'id'    =>  (string)$this->id,
            'attributes' => [
                'transaction_id' => (string)$this->TransactionCode,
                'date_placed' => $this->created_at->toDayDateTimeString(),
                'date_updated' => $this->updated_at->toDayDateTimeString(),
                'subTotal_all_items' => number_format($this->subTotal,2),
                'method' => $this->payment_method
            ],
            'relationships' => new TransactionsRelationship($this),
        ];
    }
}

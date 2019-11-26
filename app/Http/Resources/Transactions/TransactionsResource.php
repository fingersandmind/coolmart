<?php

namespace App\Http\Resources\Transactions;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Transactions\TransactionResource;

class TransactionsResource extends ResourceCollection
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
            'data' => TransactionResource::collection($this->collection)
        ];
    }
}

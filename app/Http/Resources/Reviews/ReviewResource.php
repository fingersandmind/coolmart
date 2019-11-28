<?php

namespace App\Http\Resources\Reviews;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'type' => 'reviews',
            'id' => (string)$this->id,
            'attributes' => [
                'stars' => number_format($this->stars,1),
                'star_percent_rate' => (string)$this->starRatePercent(),
                'comment' => $this->comments,
                'user' => $this->user->name,
                'date' => $this->updated_at->diffForHumans()
            ]
        ];
    }
}

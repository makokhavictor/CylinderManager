<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'orderId' => $this->id,
            'fromDepotId' => $this->depot_id,
            'fromDepotName' => $this->depot->name,
            'toDealerId' => $this->dealer_id,
            'toDealerName' => $this->dealer->name,
        ];
    }
}

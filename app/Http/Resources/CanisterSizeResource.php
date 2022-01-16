<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CanisterSizeResource extends JsonResource
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
            'canisterSizeId' => $this->id,
            'canisterSizeName' => $this->name,
            'canisterSizeValue' => $this->value,
        ];
    }
}

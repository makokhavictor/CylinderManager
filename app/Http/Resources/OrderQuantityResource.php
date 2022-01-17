<?php

namespace App\Http\Resources;

use App\Models\Brand;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderQuantityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $brand = Brand::find($this->pivot->brand_id);
        return [
            'canisterSizeId' => $this->id,
            'canisterSizeName' => $this->name,
            'value' => $this->value,
            'quantity' => $this->pivot->quantity,
            'canisterBrandId' => $this->pivot->brand_id,
            'canisterBrandName' => $brand ? $brand->name : null
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CanisterResource extends JsonResource
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
            'canisterId' => $this->id,
            'canisterCode' => $this->code,
            'canisterRecertification' => $this->recertification,
            'canisterManuf' => $this->manuf,
            'canisterManufDate' => $this->manuf_date,
            'canisterQR' => $this->QR,
            'canisterRFID' => $this->RFID,
            'canisterBrandId' => $this->brand_id,
            'canisterBrandName' => $this->brand->name,
            'canisterSize' => $this->size,
        ];
    }
}

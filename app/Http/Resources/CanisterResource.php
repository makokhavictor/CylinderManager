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
            'id' => $this->id,
            'canisterCode' => $this->code,
            'canisterRecertification' => $this->recertification,
            'canisterManuf' => $this->manuf,
            'canisterManufDate' => $this->manuf_date,
            'canisterQR' => $this->QR,
            'canisterRFID' => $this->RFID,
            'brandId' => $this->brand_id,
            'brandName' => $this->brand->name,
        ];
    }
}

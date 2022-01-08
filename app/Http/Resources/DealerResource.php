<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DealerResource extends JsonResource
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
            'dealerId' => $this->id,
            'dealerName' => $this->name,
            'dealerCode' => $this->code,
            'dealerEPRALicenceNo' => $this->EPRA_licence_no,
            'dealerLocation' => $this->location,
            'dealerGPS' => $this->GPS
        ];
    }
}

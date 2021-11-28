<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepotResource extends JsonResource
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
            'id' =>$this->id,
            'depotCode' =>$this->code,
            'depotName' =>$this->name,
            'depotEPRALicenceNo' =>$this->EPRA_license_no,
            'depotLocation' =>$this->location,
        ];
    }
}

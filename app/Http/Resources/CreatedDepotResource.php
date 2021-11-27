<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatedDepotResource extends JsonResource
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
            'data' => [
                'id' => $this->id,
                'depotName' => $this->name,
                'depotEPRALicenceNo' =>$this->EPRA_licence_no,
                'depotLocation' =>$this->location
            ],
            'headers' => [
                'message' => 'Depot created successfully'
            ]
        ];
    }
}

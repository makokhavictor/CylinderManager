<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractedTransporterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'transporterId' =>$this->id,
            'transporterCode' =>$this->code,
            'transporterName' =>$this->name,
            'contractExpiryDate' =>$this->pivot->expires_at,
            'noExpiry' => !$this->pivot->expires_at
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Role;
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
            'depotEPRALicenceNo' =>$this->EPRA_licence_no,
            'depotLocation' =>$this->location,
            'brands' => BrandResource::collection($this->brands),
            'brandIds' => $this->brands->pluck('id'),
            'depotRoles' => RoleResource::collection(Role::find($this->stationRoles->pluck('role_id')))
        ];
    }
}

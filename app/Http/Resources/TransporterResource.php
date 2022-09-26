<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class TransporterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'transporterId' =>$this->id,
            'transporterCode' =>$this->code,
            'transporterName' =>$this->name,
            'transporterRoles' => RoleResource::collection(Role::find($this->stationRoles->pluck('role_id')))
        ];
    }
}

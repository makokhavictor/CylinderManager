<?php

namespace App\Http\Resources;

use App\Models\Dealer;
use App\Models\Depot;
use App\Models\StationPermission;
use App\Models\Transporter;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $dealer = null;
        $depot = null;
        $transporter = null;
        if($this->pivot) {
            if($this->pivot->permissible_type === Depot::class) {
                $depot = Depot::find($this->pivot->permissible_id);
            }

            elseif($this->pivot->permissible_type === Transporter::class) {
                $transporter = Transporter::find($this->pivot->permissible_id);
            }

            elseif($this->pivot->permissible_type === Dealer::class) {
                $dealer = Dealer::find($this->pivot->permissible_id);
            }
        }
        return [
            'roleId' => $this->id,
            'roleName' => $this->name,
            'permissions' => PermissionResource::collection($this->permissions),
            'depotId' => $this->when($depot, $depot?->id),
            'depotName' => $this->when($depot, $depot?->name),
            'dealerId' => $this->when($dealer, $dealer?->id),
            'dealerName' => $this->when($dealer, $dealer?->name),
            'transporterId' => $this->when($transporter, $transporter?->id),
            'transporterName' => $this->when($transporter, $transporter?->name),
        ];
    }
}

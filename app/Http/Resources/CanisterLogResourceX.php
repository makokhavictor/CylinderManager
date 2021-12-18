<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CanisterLogResourceX extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $toDepotName = $this->toDepot ? $this->toDepot->name : null;
        $fromDepotName = $this->fromDepot ? $this->fromDepot->name : null;
        $toDealerName =  $this->toDealer ? $this->toDealer->name : null;
        $fromDealerName = $this->fromDealer ? $this->fromDealer->name : null;
        $toTransporterName = $this->toTransporter ? $this->toTransporter->name : null;
        $fromTransporterName = $this->fromTransporter ? $this->fromTransporter->name : null;

        return [
            'id' => $this->id,
            'toDepotId' => $this->when($this->to_depot_id, $this->to_depot_id),
            'toDepotName' => $this->when($this->to_depot_id, $toDepotName),
            'fromDepotId' => $this->when($this->from_depot_id, $this->from_depot_id),
            'fromDepotName' => $this->when($this->from_depot_id, $fromDepotName),
            'toDealerId' => $this->when($this->to_dealer_id, $this->to_dealer_id),
            'toDealerName' => $this->when($this->to_dealer_id, $toDealerName),
            'fromDealerId' => $this->when($this->from_dealer_id, $this->from_dealer_id),
            'fromDealerName' => $this->when($this->from_dealer_id, $fromDealerName),
            'toTransporterId' => $this->when($this->to_transporter_id, $this->to_transporter_id),
            'toTransporterName' => $this->when($this->to_transporter_id, $toTransporterName),
            'fromTransporterId' => $this->when($this->from_transporter_id, $this->from_transporter_id),
            'fromTransporterName' => $this->when($this->from_transporter_id, $fromTransporterName),
            'canisterQR' => $this->canister->QR,
            'brandId' => $this->canister->brand->id,
            'brandName' => $this->canister->brand->name,
            'filled' =>  $this->filled,
        ];
    }
}

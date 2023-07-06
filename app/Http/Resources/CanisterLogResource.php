<?php

namespace App\Http\Resources;

use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Transporter;
use Illuminate\Http\Resources\Json\JsonResource;

class CanisterLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $fromDepot = Depot::find($this->fromable_id);
        $fromDealer = Dealer::find($this->fromable_id);
        $fromTransporter = Transporter::find($this->fromable_id);
        $toDepot = Depot::find($this->toable_id);
        $toDealer = Dealer::find($this->toable_id);
        $toTransporter = Transporter::find($this->toable_id);
        return [
            'id' => $this->id,
            'fromDepotId' => $this->when($this->fromable_type === Depot::class, $this->fromable_id),
            'fromDealerId' => $this->when($this->fromable_type === Dealer::class, $this->fromable_id),
            'fromTransporterId' => $this->when($this->fromable_type === Transporter::class, $this->fromable_id),
            'toDepotId' => $this->when($this->toable_type === Depot::class, $this->toable_id),
            'toDealerId' => $this->when($this->toable_type === Dealer::class, $this->toable_id),
            'toTransporterId' => $this->when($this->toable_type === Transporter::class, $this->toable_id),
            'fromDepotName' => $this->when($this->fromable_type === Depot::class, $fromDepot ? $fromDepot->name: null),
            'fromDealerName' => $this->when($this->fromable_type === Dealer::class, $fromDealer ? $fromDealer->name : null),
            'fromTransporterName' => $this->when($this->fromable_type === Transporter::class, $fromTransporter ? $fromTransporter->name : null),
            'toDepotName' => $this->when($this->toable_type === Depot::class, $toDepot ? $toDepot->name : null),
            'toDealerName' => $this->when($this->toable_type === Dealer::class, $toDealer ? $toDealer->name : null),
            'toTransporterName' => $this->when($this->toable_type === Transporter::class, $toTransporter ? $toTransporter->name : null),
            'canisterId' => $this->canister->id,
            'canisterBrandId' => $this->canister->brand->id,
            'canisterSizeId' => $this->canister->canisterSize->id,
            'canisterSizeName' => $this->canister->canisterSize->name,
            'canisterBrandName' => $this->canister->brand->name,
            'filled' => $this->filled,
        ];
    }
}

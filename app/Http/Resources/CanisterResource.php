<?php

namespace App\Http\Resources;

use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Transporter;
use Illuminate\Http\Resources\Json\JsonResource;

class CanisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $lastLog = $this->canisterLogs()->latest()->first();
        $toDepot = $lastLog ? Depot::find($lastLog->toable_id) : null;
        $toDealer = $lastLog ? Dealer::find($lastLog->toable_id) : null;
        $toTransporter = $lastLog ? Transporter::find($lastLog->toable_id) : null;
        $toDepotId = $toDepot?->id;
        $toDealerId = $toDealer?->id;
        $toTransporterId = $toTransporter?->id;
        $toDepotName = $toDepot?->name;
        $toDealerName = $toDealer?->id;
        $toTransporterName = $toTransporter?->id;
        $currentStation = $toDepotId ? 'Depot' : ($toDealerId ? 'Dealer' : ($toTransporterId ? 'Transporter' : null));
        $currentStationName = $toDepotName ?? $toDealerName ?? $toTransporterName;
        return [
            'currentlyAtDepotId' => $this->when($lastLog && $lastLog->toable_type === Depot::class, $toDepotId),
            'currentlyAtDealerId' => $this->when($lastLog && $lastLog->toable_type === Dealer::class, $toDealerId),
            'currentlyAtTransporterId' => $this->when($lastLog && $lastLog->toable_type === Transporter::class, $toTransporterId),
            'currentlyAtDepotName' => $this->when($lastLog && $lastLog->toable_type === Depot::class, $toDepotName),
            'currentlyAtDealerName' => $this->when($lastLog && $lastLog->toable_type === Dealer::class, $toDealerName),
            'currentlyAtTransporterName' => $this->when($lastLog && $lastLog->toable_type === Transporter::class, $toTransporterName),
            'canisterCurrentStation' => $currentStation,
            'canisterCurrentStationName' => $currentStationName,

            'currentlyFilled' => !!$this->when($lastLog, $lastLog?->filled),
            'canisterId' => $this->id,
            'canisterCode' => $this->code,
            'canisterRecertificationDate' => $this->recertification_date,
            'canisterManuf' => $this->manuf,
            'canisterManufDate' => $this->manuf_date,
            'canisterRFID' => $this->RFID,
            'canisterBrandId' => $this->brand_id,
            'canisterBrandName' => $this->brand?->name,
            'canisterSizeId' => $this->canister_size_id,
            'canisterSizeName' => $this->canisterSize->name,
        ];
    }
}

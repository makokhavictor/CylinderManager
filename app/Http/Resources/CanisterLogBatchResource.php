<?php

namespace App\Http\Resources;

use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Transporter;
use Illuminate\Http\Resources\Json\JsonResource;

class CanisterLogBatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $fromDepot = $this->fromable_type === Depot::class ? Depot::find($this->fromable_id) : null;
        $fromDealer = $this->fromable_type === Dealer::class ? Dealer::find($this->fromable_id) : null;
        $transporter = Transporter::find($this->transporter_id);
        $toDepot = $this->toable_type === Depot::class ? Depot::find($this->toable_id) : null;
        $toDealer = $this->toable_type === Dealer::class ? Dealer::find($this->toable_id) : null;

        return [
            'canisterBatchId' => $this->id,
            'canisterBatchReceived' => $this->received,
            'fromDepotId' => $this->when($fromDepot, $fromDepot ? $fromDepot->id : null),
            'fromDealerId' => $this->when($fromDealer, $fromDealer ? $fromDealer->id : null),
            'toDepotId' => $this->when($toDepot, $toDepot ? $toDepot->id : null),
            'toDealerId' => $this->when($toDealer, $toDealer ? $toDealer->id : null),
            'fromDepotName' => $this->when($fromDepot, $fromDepot ? $fromDepot->name : null),
            'fromDealerName' => $this->when($fromDealer, $fromDealer ? $fromDealer->name : null),
            'toDepotName' => $this->when($toDepot, $toDepot ? $toDepot->name : null),
            'toDealerName' => $this->when($toDealer, $toDealer ? $toDealer->name : null),
            'transporterId' => $this->transporter_id,
            'transporterName' => $transporter->name,
            'canisters' => CanisterLogResource::collection($this->canisterLogs)
        ];
    }
}

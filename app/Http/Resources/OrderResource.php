<?php

namespace App\Http\Resources;

use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Transporter;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $depotToTransporter = $this->canisterLogs->where('fromable_type', Depot::class)->count() > 0;
        $transporterToDealer = $this->canisterLogs->where('toable_type', Dealer::class)->count() > 0;
        $dealerToTransporter = $this->canisterLogs->where('fromable_type', Dealer::class)->count() > 0;
        $transporterToDepot = $this->canisterLogs->where('toable_type', Depot::class)->count() > 0;

        $completion = [
            $this->assigned_at ? 1 : 0,
            $this->accepted_at ? 1: 0,
            $this->depot_transporter_ok_at === null ? 0: 1,
            $this->transporter_dealer_ok_at === null ? 0: 1,
            $this->dealer_transporter_ok_at === null ? 0: 1,
            $this->transporter_depot_ok_at === null ? 0: 1,
            $depotToTransporter ? 1: 0,
            $transporterToDealer ? 1: 0,
            $dealerToTransporter ? 1: 0,
            $transporterToDepot ? 1: 0,
        ];

        return [
            'orderId' => $this->id,
            'orderCompletionStatus' => array_sum($completion)/sizeof($completion),
            'fromDepotId' => $this->depot_id,
            'fromDepotName' => $this->depot->name,
            'toDealerId' => $this->dealer_id,
            'toDealerName' => $this->dealer->name,
            'assignedToTransporterId' => $this->assigned_to,
            'assignedToTransporterName' => $this->transporter ? $this->transporter->name : null,
            'isAssigned' => !!$this->assigned_at,
            'isAccepted' => !!$this->accepted_at,
            'acceptedAt' => $this->accepted_at,
            'assignedAt' => $this->assigned_at,

            'depotToTransporter' => $depotToTransporter,
            'transporterToDealer' => $transporterToDealer,
            'dealerToTransporter' => $dealerToTransporter,
            'transporterToDepot' => $transporterToDepot,

            'depotToTransporterConfirmed' => $this->depot_transporter_ok_at,
            'transporterToDealerConfirmed' => $this->transporter_dealer_ok_at,
            'dealerToTransporterConfirmed' => $this->dealer_transporter_ok_at,
            'transporterToDepotConfirmed' => $this->transporter_depot_ok_at,

            'depotToTransporterConfirmedAt' => $this->depot_transporter_ok_at,
            'transporterToDealerConfirmedAt' => $this->transporter_dealer_ok_at,
            'dealerToTransporterConfirmedAt' => $this->dealer_transporter_ok_at,
            'transporterToDepotConfirmedAt' => $this->transporter_depot_ok_at,




            'orderQuantities' => OrderQuantityResource::collection($this->canisterSizes)
        ];
    }
}

<?php

namespace App\Http\Resources;

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
        $completion = [
            $this->assigned_at ? 1 : 0,
            $this->accepted_at ? 1: 0,
            $this->depot_scanned ? 1: 0,
            $this->depot_to_transporter_scanned ? 1: 0,
            $this->depot_to_transporter_received ? 1: 0,
            $this->dealer_to_transporter_scanned ? 1: 0,
            $this->dealer_to_transporter_received ? 1: 0,
            $this->dealer_to_depot_delivered ? 1: 0,
            $this->dealer_to_depot_received ? 1: 0,
            $this->depot_to_dealer_delivered ? 1: 0,
            $this->depot_to_dealer_received ? 1: 0,
        ];

        return [
            'orderId' => $this->id,
            'orderCompletionStatus' => array_sum($completion)/11,
            'fromDepotId' => $this->depot_id,
            'fromDepotName' => $this->depot->name,
            'toDealerId' => $this->dealer_id,
            'toDealerName' => $this->dealer->name,
            'assignedToTransporterId' => $this->assigned_to,
            'assignedToTransporterName' => $this->transporter ? $this->transporter->name : null,
            'isAssigned' => !!$this->assigned_at,
            'assignedAt' => $this->assigned_at,
            'orderQuantities' => OrderQuantityResource::collection($this->canisterSizes)
        ];
    }
}

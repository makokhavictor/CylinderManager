<?php

namespace App\Http\Resources;

use App\Models\CanisterLog;
use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Transporter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatedCanisterLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => CanisterLogBatchResource::make($this),
            'headers' => [
                'message' => 'Successfully added canister log'
            ]
        ];
    }
}

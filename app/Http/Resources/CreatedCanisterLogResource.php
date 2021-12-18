<?php

namespace App\Http\Resources;

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
            'data' => [
                'batchId' => $this->id,
                'canisters' => CanisterLogResourceX::collection($this->canisterLogs)
            ],
            'headers' => [
                'message' => 'Successfully added canister log'
            ]
        ];
    }
}

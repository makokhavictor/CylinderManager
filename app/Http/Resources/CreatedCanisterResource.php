<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreatedCanisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => CanisterResource::make($this),
            'headers' => [
                'message' => 'Successfully created canister'
            ]
        ];
    }
}

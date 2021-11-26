<?php

namespace App\Http\Resources;

use App\Models\Dealer;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatedDealerResource extends JsonResource
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
            'data' => [
                'id' => $this->id,
                'permissions' => User::find($this->user_id)->getAllPermissions()->pluck('name'),
                'roles' => User::find($this->user_id)->roles()->pluck('name')
            ],
            'headers' => [
                'message' => 'Successfully created dealer'
            ]
        ];
    }
}

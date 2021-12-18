<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatedTransporterUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'id' => $this->id,
                'permissions' => User::find($this->user_id)->getAllPermissions()->pluck('name'),
                'roles' => User::find($this->user_id)->roles()->pluck('name'),
                'countyId' => $this->county->id,
                'countyName' => $this->county->name,
            ],
            'headers' => [
                'message' => 'Transporter role successfully updated'
            ]
        ];
    }
}

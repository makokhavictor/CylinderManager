<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'createdAt' => $this->created_at,
            'transporterId' => $this->when(!!$this->transporter_id, $this->transporter_id),
            'depotUserId' => $this->when(!!$this->depot_user_id, $this->depot_user_id),
            'profileDescription' => $this->profile_description,
            'emailVerified' => !!$this->email_verified_at,
            'emailVerifiedAt' => $this->email_verified_at,
            'phoneVerified' => !!$this->phone_verified_at,
            'phoneVerifiedAt' => $this->phone_verified_at,
            'profilePictureLink' => $this->profile_picture_link,
            'roles' => $this->roles->pluck('name'),
            'permissions' => $this->getAllPermissions()->pluck('name'),
        ];
    }
}

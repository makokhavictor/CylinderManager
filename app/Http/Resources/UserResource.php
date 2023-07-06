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
            'userId' => $this->id,
            'username' => $this->username,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'createdAt' => $this->created_at,
            'profileDescription' => $this->profile_description,
            'emailVerified' => !!$this->email_verified_at,
            'emailVerifiedAt' => $this->email_verified_at,
            'phoneVerified' => !!$this->phone_verified_at,
            'phoneVerifiedAt' => $this->phone_verified_at,
            'profilePictureLink' => $this->profile_picture_link,
            'lastActivityAt' => $this->last_activity_at,
            'lastLoginAt' => $this->last_login_at,
            'lastLoginIp' => $this->last_login_ip,
            'roles' => $this->roles->pluck('name'),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'stationSpecificRoles' => RoleResource::collection($this->permissibleRoles)

        ];
    }
}

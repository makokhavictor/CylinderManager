<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class CreatedUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $token = $this->createToken('Personal', ['*']);
        return [
            'data' => [
                'user' => UserResource::make($this),
                'token' => [
                    'access_token' => $token->accessToken,
                    'expires_in' => $token->token->expires_at
                ]
            ],
            'header' => [
                'message' => 'You have been successfully registered'
            ]
        ];
    }
}

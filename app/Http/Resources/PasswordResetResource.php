<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PasswordResetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $token =  $this->createToken('Personal Access Client');
        return [
            'data' => [
                'access_token' => $token->accessToken,
                'token_type' => 'Bearer',
            ],
            'message' => [
                'message' => 'Successfully Authenticated'
            ]
        ];
    }
}

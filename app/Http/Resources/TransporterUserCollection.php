<?php

namespace App\Http\Resources;

use App\Models\DepotUser;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransporterUserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => TransporterUserResource::collection($this)
        ];
    }
}

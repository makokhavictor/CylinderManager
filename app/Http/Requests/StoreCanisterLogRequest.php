<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class StoreCanisterLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return User::find(auth()->id())->can('dispatch canister');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'toDepotId' => 'exists:depots,id|required_without_all:toTransporterId,toDealerId',
            'canisters' => 'required|array|min:1',
            'canisters.*.canisterId' => 'required|exists:canisters,id',
//            'canisters.*.canisterQR' => 'required|exists:canisters,QR',
            'canisters.*.filled' => 'required',
            'toDealerId' => 'exists:dealers,id',
            'transporterId' => 'exists:transporters,id',
            'fromDepotId' => 'exists:depots,id',
            'fromDealerId' => 'exists:dealers,id',

        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException( 'You are not authorised to create a canister log');
    }
}

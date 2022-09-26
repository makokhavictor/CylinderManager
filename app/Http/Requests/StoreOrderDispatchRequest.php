<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderDispatchRequest extends FormRequest
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
            'from' => 'required',
            'canisters' => 'required|array|min:1',
            'canisters.*.canisterId' => 'exists:canisters,id',
            'canisters.*.canisterSizeId' => 'exists:canister_sizes,id',
            'canisters.*.canisterBrandId' => 'exists:brands,id'
        ];
    }
    protected function failedAuthorization()
    {
        throw new AuthorizationException( 'You are not authorised to dispatch cylinders');
    }
}

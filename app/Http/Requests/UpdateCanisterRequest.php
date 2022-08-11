<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCanisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return User::find(auth()->id())->can('update canister');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'canisterCode' => 'required',
            'canisterManuf' => 'required',
            'canisterManufDate' => 'required|date',
            'canisterBrandId' => 'required',
            'canisterRFID' => 'required|unique:canisters,RFID,'.$this->canister->id,
            'canisterRecertification' => 'required'
        ];
    }
}

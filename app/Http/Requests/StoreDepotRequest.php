<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreDepotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return User::find(auth()->id())->can('create depot');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'depotName' => 'required',
            'depotCode' => 'required',
            'depotEPRALicenceNo' => 'required|unique:depots,EPRA_licence_no',
            'depotLocation' => 'required',
            'canisterBrandIds' => 'required|array|min:1',
            "canisterBrandIds.*"  => "required|distinct|exists:brands,id",
        ];
    }
}

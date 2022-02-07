<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // return User::find(auth()->id())->can('create refill order');
        // TODO check why logged in dealer cannot create an order
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fromDepotId' => 'required',
            'toDealerId' => 'required',
            'orderQuantities' => 'required',
            'orderQuantities.*.canisterBrandId' => 'required',
            'orderQuantities.*.canisterSizeId' => 'required',
            'orderQuantities.*.quantity' => 'required',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $authUser = User::find(auth()->id());
        return $authUser->can('admin: assign order')
            || $authUser->can('assign order')
            || $authUser->can('admin: accept refill order')
            || $authUser->can('accept refill order')

            || $authUser->can('confirm dispatch from depot')
            || $authUser->can('admin: confirm dispatch from depot');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException( 'You are not authorised to perform this action on an order');
    }
}

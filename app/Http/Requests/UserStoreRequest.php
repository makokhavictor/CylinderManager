<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return User::find(auth()->id())->can('create user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'nullable|unique:users,username',
            'firstName' => 'required',
            'lastName' => 'required',
            'phone' => 'nullable|unique:users,phone',
            'email' => 'nullable|email|required_without:phone|unique:users,email',
        ];
    }
}

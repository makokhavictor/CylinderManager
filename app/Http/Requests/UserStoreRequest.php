<?php

namespace App\Http\Requests;

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
        return true;
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
            'phone' => 'unique:users,phone',
            'email' => 'nullable|email|required_without:phone|unique:users,email',
            'password' => 'required',
            'passwordConfirmation' => 'required|same:password'
        ];
    }
}

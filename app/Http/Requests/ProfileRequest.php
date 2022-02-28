<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileRequest extends FormRequest
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
            'email' => [
                'required',
                'unique:App\Models\User,email',
                'max:255',
                'email:rfc'
            ],
            'fullname' => [
                'max:256',
                'min:3',
                'string',
                'regex:/[a-z]/'
            ],

            'password' => [
                'required',
                Password::min(6)->mixedCase(),
                'max:30',
            ],
            'avatar' => ['max:255'],
        ];
    }
}

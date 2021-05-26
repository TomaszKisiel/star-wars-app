<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class RegisterRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules() {
        return [
            'email' => [ 'required', 'email', 'max:255', 'unique:users' ],
            'password' => [ 'required', 'min:8', 'max:64', 'regex:/(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\W])/', 'confirmed' ]
        ];
    }

    public function messages() {
        return [
            'password.regex' => 'Password is too weak. At least one letter, number and special character are required.'
        ];
    }
}

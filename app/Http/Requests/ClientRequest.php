<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
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
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'digits:10'],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'The first name field is required',
            'last_name.required' => 'The last name field is required',
            'email.required' => 'The email field is required',
            'phone_number.required' => 'The phone number field is required',
            
        ];
    }
}
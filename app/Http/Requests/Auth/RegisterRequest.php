<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
            'address' => ['required', 'string', 'regex:/^[a-zA-Z0-9\s.,-]+$/', 'max:255'],
            'phone' => ['required', 'digits:10'],
            'blood_type' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'age' => ['required', 'integer', 'between:18,60'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'user_type' => ['required', 'array', 'min:1'],
            'user_type.*' => ['required', 'in:donor,receiver,both'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Name should only contain alphabets and spaces.',
            'address.regex' => 'Address contains invalid characters.',
            'phone.digits' => 'Phone should be a 10-digit number.',
        ];
    }
}

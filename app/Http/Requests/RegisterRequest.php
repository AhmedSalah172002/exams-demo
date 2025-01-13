<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends  CustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow all users to make this request.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function wantsJson(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $rules =  [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|in:user,admin',
        ];
        return $rules;
    }
    public function messages(): array
    {
        return [
            'username.required' => 'username must be required',
            'email.required' => 'email must be required',
            'email.unique' => 'email must be unique',
            'email.email' => 'email must be valid email address',
            'password.required' => 'password must be required',
            'password.min' => 'password must be at least 6 characters',
            'password.confirmed' => 'password must be confirmed',
            'role.required' => 'role must be required',
            'role.in' => 'role must be user or admin',
        ];
    }
}

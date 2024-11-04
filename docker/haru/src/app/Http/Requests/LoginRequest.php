<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Emailの入力がありません',
            'password.required' => 'Passwordの入力がありません',
            'password.min' => 'Passwordは6文字以上である必要があります',
            'password.regex' => 'Passwordには小文字、大文字、数字を含める必要があります',
        ];
    }
}

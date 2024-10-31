<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|string|min:6|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nameの入力がありません',
            'email.required' => 'Emailの入力がありません',
            'email.unique' => 'このEmailはすでに使用されています',
            'password.required' => 'Passwordの入力がありません',
            'password.min' => 'Passwordは6文字以上である必要があります', 
        ];
    }
}

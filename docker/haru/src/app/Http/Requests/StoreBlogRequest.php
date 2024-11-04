<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,webp',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'required|array',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => '画像を挿入してください',
            'image.image' => '画像は画像ファイルである必要があります。',
            'image.mimes' => '画像はjpeg、png、jpg、またはwebp形式である必要があります。',
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは255文字以内でなければなりません。',
            'content.required' => '内容を入力してください。',
            'categories.required' => '少なくとも1つのカテゴリを選択してください。',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category' => ['required'],
            'title2' => ['required', 'max:30'],
            'url' => ['required', 'active_url'],
        ];
    }

    public function attributes()
    {
        return [
            'category' => 'カテゴリー',
            'title2' => 'タイトル',
        ];
    }
}

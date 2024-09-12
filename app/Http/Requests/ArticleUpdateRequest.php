<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The article title is required.',
            'content.required' => 'The article content is required.',
            'excerpt.required' => 'The article excerpt is required.',
            'excerpt.max' => 'The excerpt may not be greater than 255 characters.',
            'category_id.required' => 'Please select a category for the article.',
            'category_id.exists' => 'The selected category does not exist.',
        ];
    }
}

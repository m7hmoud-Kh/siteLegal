<?php

namespace App\Http\Requests\Dashboard\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
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
            'name_en' => ['string',Rule::unique('blogs')->ignore($this->blogId)],
            'name_ar' => ['string',Rule::unique('blogs')->ignore($this->blogId)],
            'description_ar' => ['string'],
            'description_en' => ['string'],
            'status' => ['boolean'],
            'image' => ['mimes:jpg,png,jpeg,svg']
        ];
    }
}

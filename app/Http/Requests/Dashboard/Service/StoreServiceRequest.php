<?php

namespace App\Http\Requests\Dashboard\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'name_en' => ['required','string','unique:services'],
            'name_ar' => ['required','string','unique:services'],
            'description_ar' => ['required','string'],
            'description_en' => ['required','string'],
            'image' => ['required','mimes:jpg,png,jpeg,svg']
        ];
    }
}

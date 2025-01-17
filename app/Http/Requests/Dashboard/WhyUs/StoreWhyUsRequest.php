<?php

namespace App\Http\Requests\Dashboard\WhyUs;

use Illuminate\Foundation\Http\FormRequest;

class StoreWhyUsRequest extends FormRequest
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
            'name_en' => ['required','string','unique:why_us'],
            'name_ar' => ['required','string','unique:why_us'],
            'description_en' => ['required','string'],
            'description_ar' => ['required','string'],
            'icon' => ['required','string']

        ];
    }
}

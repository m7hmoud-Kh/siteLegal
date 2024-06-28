<?php

namespace App\Http\Requests\Dashboard\Section;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectionRequest extends FormRequest
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
            'name_en' => ['required','string','unique:sections'],
            'name_ar' => ['required','string','unique:sections'],
            'description_ar' => ['required','string'],
            'description_en' => ['required','string'],
            'service_id' => ['required','exists:services,id'],
            'image' => ['required','mimes:jpg,png,jpeg']
        ];
    }
}

<?php

namespace App\Http\Requests\Dashboard\WhyUs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWhyUsRequest extends FormRequest
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
            'name_en' => ['string',Rule::unique('why_us')->ignore($this->whyUsId)],
            'name_ar' => ['string',Rule::unique('why_us')->ignore($this->whyUsId)],
            'description_en' => ['string'],
            'description_ar' => ['string'],
            'icon' => ['string'],
            'status' => ['boolean']
        ];
    }
}

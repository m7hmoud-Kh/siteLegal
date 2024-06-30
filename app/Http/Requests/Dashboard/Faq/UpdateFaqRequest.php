<?php

namespace App\Http\Requests\Dashboard\Faq;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFaqRequest extends FormRequest
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
            'question_en' => ['required','string',Rule::unique('faqs')->ignore($this->faqId)],
            'question_ar' => ['required','string',Rule::unique('faqs')->ignore($this->faqId)],
            'answer_en' => ['required','string'],
            'answer_ar' => ['required','string'],
            'status' => ['boolean']
        ];
    }
}

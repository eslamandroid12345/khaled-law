<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionRequest extends FormRequest
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
            'service_id' => ['nullable',Rule::exists('services','id')],
            'question_en' => ['required', 'string', 'max:255'],  // Limiting the length for better data integrity
            'question_ar' => ['required', 'string', 'max:255'],  // Limiting the length for better data integrity
            'answer_en' => ['required', 'string'],      // String validation for English description
            'answer_ar' => ['required', 'string'],      // String va
        ];
    }
}

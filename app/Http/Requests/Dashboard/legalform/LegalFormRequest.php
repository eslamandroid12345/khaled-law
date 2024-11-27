<?php

namespace App\Http\Requests\Dashboard\Legalform;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class LegalFormRequest extends FormRequest
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
                    'name_en' => ['required', 'string', 'max:255'],  // Limiting the length for better data integrity
                    'name_ar' => ['required', 'string', 'max:255'],  // Limiting the length for better data integrity
                    'description_ar' => ['required', 'string'],      // String validation for Arabic description
                    'description_en' => ['required', 'string'],      // String validation for English description
                    'price' => ['required', 'numeric', 'min:0'],     // Ensures the price is a non-negative number
                    'file' => [
                        $this->isMethod('post') ? 'required' : 'nullable',
                        'file',
                        'mimes:pdf,jpeg,png,doc,docx',
                        'max:4096'
                    ],
                    'image' => [
                        $this->isMethod('post') ? 'required' : 'nullable',
                        'image',
                        'mimes:jpeg,png,jpg,gif,svg',
                        'max:4096'
                    ],
        ];
    }
}

<?php

namespace App\Http\Requests\Dashboard\Service;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ServiceRequest extends FormRequest
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
                    'required_files_en' => ['required', 'string'],      // String validation for Arabic description
                    'required_files_ar' => ['required', 'string'],      // String validation for English description
                    'desc_en' => ['required', 'string'],      // String validation for English description
                    'desc_ar' => ['required', 'string'],      // String validation for English description
                    'price' => ['nullable', 'numeric'],      // String validation for English description
                    'category_id' => ['required',Rule::exists('categories','id')],
                    'image' => [
                        $this->isMethod('post') ? 'required' : 'nullable',
                        'image',
                        'mimes:jpeg,png,jpg,gif,svg',
                        'max:4096'
                    ],
        ];
    }
}

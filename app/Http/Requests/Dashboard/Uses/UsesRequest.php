<?php

namespace App\Http\Requests\Dashboard\Uses;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UsesRequest extends FormRequest
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
            'title_ar' => ['required', 'string', 'max:255'],  // Limiting the length for better data integrity
            'title_en' => ['required', 'string', 'max:255'],  // Limiting the length for better data integrity
            'description_ar' => ['required', 'string'],      // String validation for Arabic description
            'description_en' => ['required', 'string'],      // String validation for English description
            'image' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:4096'
            ],
            'sort' => ['nullable', 'numeric'],
        ];
    }
}

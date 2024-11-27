<?php

namespace App\Http\Requests\Dashboard\Category;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CategoryRequest extends FormRequest
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
        ];
    }
}

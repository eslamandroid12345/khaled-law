<?php

namespace App\Http\Requests\Dashboard\Lawyer;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class LawyerRequest extends FormRequest
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
                    'name' => ['required', 'string'],
                    'job_title_ar' => ['required', 'string'],
                    'job_title_en' => ['required', 'string'],
                    'description_ar' => ['required', 'string'],
                    'description_en' => ['required', 'string'],
                    'phone' => ['required', 'numeric'],
                    'image' => ['nullable', 'image','mimes:jpeg,png,jpg,gif,svg|max:4096'],
                    'email' => [
                        'required',
                        // 'email:rfc,dns',
                        'email',
                        $this->method() == 'POST'
                            ? Rule::unique('managers', 'email')
                            : Rule::unique('managers', 'email')->ignore($this->id, 'id')
                    ],
                    'password' => $this->password ?['required', Password::min(8),'confirmed'] :'nullable',
                ];
    }
}

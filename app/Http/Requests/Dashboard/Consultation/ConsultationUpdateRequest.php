<?php

namespace App\Http\Requests\Dashboard\Consultation;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ConsultationUpdateRequest extends FormRequest
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
                'meet_link' => [
                    'sometimes',  // Apply the rule only if the condition is met
                    function ($attribute, $value, $fail) {
                        if ($this->type === 'ONLINE' && empty($value)) {
                            $fail(__('validation.required', ['attribute' => $attribute]));
                        }
                    }
                ],
                'case' => ['required'],
                'date' => ['nullable'],
            ];
    }
}

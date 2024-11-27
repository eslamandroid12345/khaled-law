<?php

namespace App\Http\Requests\Dashboard\Consultation;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ConsultationRequest extends FormRequest
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
                'lawyer_id' => ['required',Rule::exists('users','id')->where('type','LAWYER')],
                'consultation_id' => ['required',Rule::exists('consultations','id')]
            ];
    }
}

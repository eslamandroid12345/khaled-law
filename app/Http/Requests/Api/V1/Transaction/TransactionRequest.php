<?php

namespace App\Http\Requests\Api\V1\Transaction;

use App\Http\Enums\AttachmentTypeEnum;
use App\Http\Enums\OrderDataTypeEnum;
use App\Http\Enums\UserTypeEnum;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
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
            'consultation_id' => ['required', Rule::exists('consultations', 'id')],
            'type' => ['required', Rule::in(['BANK', 'ELECTRONIC'])], // Ensure type is either BANK or ELECTRONIC
            'price' => ['nullable'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:10240', 'required_if:type,BANK'], // Image required if type is BANK
            'user_id' => ['nullable'],
        ];
    }
}

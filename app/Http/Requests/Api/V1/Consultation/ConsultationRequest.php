<?php

namespace App\Http\Requests\Api\V1\Consultation;

use App\Http\Enums\AttachmentTypeEnum;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                    'type' => ['required', 'in:ONLINE,OFFLINE'], // Ensures type is either ONLINE or OFFLINE
//                    'status' => ['required', 'in:PAID,UNPAID'],  // Ensures status is either PAID or UNPAID
                    'at' => ['required'],                // 'date' is more appropriate than 'dateTime'
                    'name' => ['nullable', 'string', 'max:255'], // Added max length for consistency
                    'id_number' => ['required', 'string'], // Ensure ID is exactly 10 characters long
                    'address' => ['required', 'string', 'max:255'],   // Added max length for consistency
                    'phone' => ['nullable', 'string', 'max:20'],      // Added max length to accommodate international numbers
                    'email' => ['nullable', 'email:rfc,dns', 'max:255'], // Added max length for consistency
                    'subject' => ['required', 'string', 'max:255'],   // Added max length for consistency
                    'legal_question' => ['required', 'string'],       // Left unchanged
                    'description' => ['required', 'string'],          // Left unchanged
                    'images' => ['nullable', 'array'],
                    'images.*.type' => ['required',Rule::in([AttachmentTypeEnum::IMAGE->value, AttachmentTypeEnum::FILE->value])],
                    'images.*.file' => ['required', 'mimes:pdf,doc,docx,zip,rar,jpeg,jpg,png,gif,svg,mp3,wav,ogg,mp4,mov,avi,wmv'],
                ];
    }
}

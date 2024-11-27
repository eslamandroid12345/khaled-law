<?php

namespace App\Http\Requests\Api\V1\Order;

use App\Http\Enums\AttachmentTypeEnum;
use App\Http\Enums\OrderDataTypeEnum;
use App\Http\Enums\UserTypeEnum;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            'service_id' => ['required', Rule::exists('services', 'id')],
            'lawyer_id' => ['nullable', Rule::exists('users', 'id')->where('type', UserTypeEnum::LAWYER->value)->where('is_active',true)],
            'data_type' => ['required', Rule::in([OrderDataTypeEnum::MY->value, OrderDataTypeEnum::CLIENT->value])],
            'name' => ['required', 'string', 'max:255'],
            'client_relationship' => ['required_unless:data_type,MY', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'national_id' => ['required', 'numeric'],
            'phone' => ['required', new Phone()],
            'email' => ['required', 'email:rfc,dns'],
            'case_title' => ['required', 'string', 'max:255'],
            'case_description' => ['nullable', 'string'],
            'case_conclusion' => ['nullable', 'string'],
            'attachments' => ['nullable', 'array'],
            'attachments.*.type' => ['required',Rule::in([AttachmentTypeEnum::IMAGE->value, AttachmentTypeEnum::FILE->value])],
            'attachments.*.file' => ['required', 'mimes:pdf,doc,docx,zip,rar,jpeg,jpg,png,gif,svg,mp3,wav,ogg,mp4,mov,avi,wmv'],
        ];
    }
}

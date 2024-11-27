<?php

namespace App\Http\Requests\Dashboard\Attachment;

use App\Http\Enums\AttachmentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttachmentRequest extends FormRequest
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
            'attachments' => ['required', 'array'],
            'attachments.*' => ['mimes:pdf,doc,docx,zip,rar,jpeg,jpg,png,gif,svg,mp3,wav,ogg,mp4,mov,avi,wmv'],
        ];
    }
}

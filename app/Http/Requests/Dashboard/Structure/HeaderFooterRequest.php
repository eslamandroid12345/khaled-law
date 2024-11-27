<?php

namespace App\Http\Requests\Dashboard\Structure;

use Illuminate\Foundation\Http\FormRequest;

class HeaderFooterRequest extends FormRequest
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
            'en.logo' => ['required','string'],
            'en.fav_icon' => ['required','string'],
            'en.login_image' => ['required','string'],
            'en.social.*.icon' => ['required','string'],

            'ar.logo' => ['required','string'],
            'ar.fav_icon' => ['required','string'],
            'ar.login_image' => ['required','string'],
            'ar.social.*.icon' => ['required','string'],

            'all.contacts.fax' => ['required','string'] ,
            'all.contacts.phones.*' => ['nullable','numeric'] ,
            'all.contacts.emails.*' => ['nullable','email:rfc,dns'] ,
            'all.social.*.link' => ['nullable','url'] ,

            'file.*' => ['image'],
            'old_file.*' => ['nullable','string'],
        ];
    }
}

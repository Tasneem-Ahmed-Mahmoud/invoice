<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // mimes:jpeg,jpg,png
            'file' => 'mimes:pdf,jpeg,png,jpg',
        ];
    }


    public function messages(): array
    {
        return [
            'file.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
            // 'file.required' =>"يجب رفع المرفق",
          
        ];
}
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
            //
            // uniquesections,name,'.$this->category->id
            'name' => 'required| unique:sections,name,'.$this->id,
            'description' => 'required',
        ];
    }



    public function messages(): array
{
    return [
        'name.required' => 'يرجا ادخال اسم القسم',
        'name.unique'=>'اسم القسم مسجل مسبقا',
        'description.required' => 'يرجا ادخال الوصف',
    ];
}
}

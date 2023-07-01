<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
           
                'name' => 'required|min:2',
                'description' => 'required',
        
        ];
    }

    

    public function messages(): array
{
    return [
        'name.required' => 'يرجا ادخال اسم المنتج',
        // 'name.unique'=>'اسم المنتج مسجل مسبقا',
        'description.required' => 'يرجا ادخال الوصف',
    ];
}




}

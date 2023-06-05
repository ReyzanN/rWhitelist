<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionFirstChanceRequest extends FormRequest
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
            'question' => 'required|max:255|min:1',
            'answer' => 'required|min:1|max:1000',
            'idTypeQuestion' => 'required'
        ];
    }
    public function messages() :array
    {
        return [
            'question' => 'Une question est requise, minimum 1 caractère, maximum 255',
            'answer' => 'Une réponse est requise, minimum 1 caractère, maximum 1000',
            'idTypeQuestion' => 'Un type de question est requis'
        ];
    }
}

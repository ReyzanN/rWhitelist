<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionRegistrationForCandidateRequest extends FormRequest
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
            'backgroundURL' => 'string|required',
            'idSession'  => 'required|numeric'
        ];
    }

    public function messages(): array
    {
        return [
            'backgroundURL' => 'Un background est requis',
            'idSession' => 'Une session est requise'
        ];
    }
}

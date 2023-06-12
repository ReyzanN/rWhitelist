<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAccountInformationUpdate extends FormRequest
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
            'steamid' => 'required|string',
            'birthdate' => 'required|date'
        ];
    }

    public function messages(): array {
        return [
            'steamid' => 'Un steam ID est requis',
            'birthdate' => 'Une date de naissance est requise'
        ];
    }
}

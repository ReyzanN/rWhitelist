<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecruitmentSessionRequest extends FormRequest
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
            'SessionDate' => 'date|required',
            'maxCandidate' => 'numeric|required',
            'theme' => 'max:255'
        ];
    }

    public function messages()
    {
        return [
            'SessionDate' => 'Une date est requise pour la session',
            'maxCandidate' => 'Un nombre maximum de candidats est requis',
            'theme' => 'Le thème ne doit pas excéder 255 caractères'
        ];
    }
}

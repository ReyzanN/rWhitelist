<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BanRequest extends FormRequest
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
            'discordAccountId' => 'required',
            'reason' => 'string',
            'expiration' => 'date'
        ];
    }

    public function messages()
    {
        return [
          'discordAccountId' => 'Une discord est requis',
          'reason' => 'Une raison est requise',
          'expiration' => 'Une durée de ban est requise'
        ];
    }
}

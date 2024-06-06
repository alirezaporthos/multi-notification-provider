<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserPrefrenceRequest extends FormRequest
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
        //TODO: retrive these from a config file
        $availableNoticationTypes = [
            'email', 'sms'
        ];

        return [
            'notification_prefrences' => ['nullable', 'array'],
            'notification_prefrences.*' => Rule::in($availableNoticationTypes)
        ];
    }
}

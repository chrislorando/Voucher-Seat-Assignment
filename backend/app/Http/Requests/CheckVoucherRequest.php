<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckVoucherRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'flightNumber' => ['required', 'string', 'max:20'],
            'date' => ['required', 'date'],
        ];
    }

        public function messages(): array
    {
        return [
            'flightNumber.required' => 'Flight number is required.',
            'date.required' => 'Flight date is required.',
            'date.date' => 'Flight date is invalid.',
        ];
    }
}

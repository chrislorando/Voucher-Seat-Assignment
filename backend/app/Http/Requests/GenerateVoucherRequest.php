<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class GenerateVoucherRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'id' => ['required', 'string'],
            'flightNumber' => [
                'required',
                'string',
            ],
            'date' => ['required', 'date'],
            'aircraft' => [
                'required',
                Rule::in(['ATR', 'Airbus 320', 'Boeing 737 Max']),
            ],
        ];
    }

}

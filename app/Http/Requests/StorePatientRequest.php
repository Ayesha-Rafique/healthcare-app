<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePatientRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|min:3',
            'phone' => 'required|string|unique:patients,phone',
            'email' => 'nullable|email|unique:patients,email',
            'dob' => 'nullable|date|before:today',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Full name is required',
            'full_name.min' => 'Full name must be at least 3 characters',
            'phone.required' => 'Phone number is required',
            'phone.unique' => 'This phone number is already registered',
            'email.email' => 'Please provide a valid email address',
            'email.unique' => 'This email is already registered',
            'dob.before' => 'Date of birth must be before today',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Appointment;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'doctor_name' => 'required|string|max:255',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Patient ID is required',
            'patient_id.exists' => 'Patient not found',
            'doctor_name.required' => 'Doctor name is required',
            'appointment_date.required' => 'Appointment date is required',
            'appointment_date.after_or_equal' => 'Appointment date cannot be in the past',
            'appointment_time.required' => 'Appointment time is required',
            'appointment_time.date_format' => 'Appointment time must be in HH:MM format (e.g., 14:30)',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->patient_id && $this->appointment_date && $this->appointment_time) {
                $exists = Appointment::where('patient_id', $this->patient_id)
                    ->where('appointment_date', $this->appointment_date)
                    ->where('appointment_time', $this->appointment_time)
                    ->exists();

                if ($exists) {
                    $validator->errors()->add(
                        'appointment_time',
                        'This patient already has an appointment at this date and time'
                    );
                }
            }
        });
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
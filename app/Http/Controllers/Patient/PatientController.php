<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\HttpCache\Store;

class PatientController extends Controller
{
    public function store(StorePatientRequest $request)
    {
        $validatedData = $request->validated();
        $patient = Patient::create($validatedData);

        return response()->json([
            'message' => 'Patient created successfully',
            'patient' => $patient
        ], 201);
    }
}

<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PatientController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Patient::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $patients->items(),
            'pagination' => [
                'current_page' => $patients->currentPage(),
                'per_page' => $patients->perPage(),
                'total' => $patients->total(),
                'last_page' => $patients->lastPage(),
            ]
        ], 200);
    }
    
    public function show(string $id): JsonResponse
    {
        $patient = Patient::with(['appointments' => function ($query) {
            $query->orderBy('appointment_date', 'desc')
                  ->orderBy('appointment_time', 'desc')
                  ->limit(5);
        }])->find($id);

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $patient->id,
                'full_name' => $patient->full_name,
                'phone' => $patient->phone,
                'email' => $patient->email,
                'dob' => $patient->dob,
                'created_at' => $patient->created_at,
                'updated_at' => $patient->updated_at,
                'latest_appointments' => $patient->appointments
            ]
        ], 200);
    }

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

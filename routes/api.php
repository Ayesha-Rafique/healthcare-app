<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Appointment\AppointmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('patients')->group(function () {
    Route::get('/', [PatientController::class, 'index']);          
    Route::post('/', [PatientController::class, 'store']);        
    Route::get('/{id}', [PatientController::class, 'show']);     
});

// Appointment Routes
Route::prefix('appointments')->group(function () {
    Route::get('/', [AppointmentController::class, 'index']);                    
    Route::post('/', [AppointmentController::class, 'store']);                 
    Route::patch('/{id}/status', [AppointmentController::class, 'updateStatus']); 
    Route::delete('/{id}', [AppointmentController::class, 'destroy']);           
});

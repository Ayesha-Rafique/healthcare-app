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

//1: create patient api POST
Route::post('/patients', [PatientController::class, 'store']);

//2: create appointment api POST
Route::post('/appointments', [AppointmentController::class, 'store']);

//3: get appointments api GET
Route::get('/appointments', [AppointmentController::class, 'index']);

//4: update appointment status api PATCH
Route::patch('/appointments/{id}/status', [AppointmentController::class, 'updateStatus']);

//5: delete appointment api DELETE
Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\AppointmentController;
use App\Http\Controllers\Api\V1\BillController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});

/*
|==========================================================================|
|                 API Routes - Atencion Profesional.                       |
|==========================================================================|
*/

Route::prefix('v1')->group(function () {

    //Rutas para Review
    Route::get('reviews', [ReviewController::class, 'index'])->name('api.v1.reviews.index');
    Route::post('reviews', [ReviewController::class, 'store'])->name('api.v1.reviews.store');
    Route::get('reviews/{id}', [ReviewController::class, 'show'])->name('api.v1.reviews.show');
    Route::put('reviews/{id}', [ReviewController::class, 'update'])->name('api.v1.reviews.update');
    Route::delete('reviews/{id}', [ReviewController::class, 'destroy'])->name('api.v1.reviews.destroy');

    //Rutas para Appointment
    Route::get('appointments', [AppointmentController::class, 'index'])->name('api.v1.appointments.index');
    Route::post('appointments', [AppointmentController::class, 'store'])->name('api.v1.appointments.store');
    Route::get('appointments/{id}', [AppointmentController::class, 'show'])->name('api.v1.appointments.show');
    Route::put('appointments/{id}', [AppointmentController::class, 'update'])->name('api.v1.appointments.update');
    Route::delete('appointments/{id}', [AppointmentController::class, 'destroy'])->name('api.v1.appointments.destroy');

    //Rutas para Bill
    Route::get('bills', [BillController::class, 'index'])->name('api.v1.bills.index');
    Route::post('bills', [BillController::class, 'store'])->name('api.v1.bills.store');
    Route::get('bills/{id}', [BillController::class, 'show'])->name('api.v1.bills.show');
    Route::put('bills/{id}', [BillController::class, 'update'])->name('api.v1.bills.update');
    Route::delete('bills/{id}', [BillController::class, 'destroy'])->name('api.v1.bills.destroy');
});
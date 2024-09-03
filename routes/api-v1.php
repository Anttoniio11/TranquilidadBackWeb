<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\MethodPaymentController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});

/*
|==========================================================================|
|                 API Routes - Atencion Profesional.                       |
|==========================================================================|
*/

    //Rutas para Patient
    Route::get('patients', [PatientController::class, 'index'])->name('api.v1.patients.index');
    Route::post('patients', [PatientController::class, 'store'])->name('api.v1.patients.store');
    Route::get('patients/{id}', [PatientController::class, 'show'])->name('api.v1.patients.show');
    Route::put('patients/{id}', [PatientController::class, 'update'])->name('api.v1.patients.update');
    Route::delete('patients/{id}', [PatientController::class, 'destroy'])->name('api.v1.patients.destroy');

    //Rutas para Professional
    Route::get('professionals', [ProfessionalController::class, 'index'])->name('api.v1.professionals.index');
    Route::post('professionals', [ProfessionalController::class, 'store'])->name('api.v1.professionals.store');
    Route::get('professionals/{id}', [ProfessionalController::class, 'show'])->name('api.v1.professionals.show');
    Route::put('professionals/{id}', [ProfessionalController::class, 'update'])->name('api.v1.professionals.update');
    Route::delete('professionals/{id}', [ProfessionalController::class, 'destroy'])->name('api.v1.professionals.destroy');

    //Rutas para Profession
    Route::get('professions', [ProfessionController::class, 'index'])->name('api.v1.professions.index');
    Route::post('professions', [ProfessionController::class, 'store'])->name('api.v1.professions.store');
    Route::get('professions/{id}', [ProfessionController::class, 'show'])->name('api.v1.professions.show');
    Route::put('professions/{id}', [ProfessionController::class, 'update'])->name('api.v1.professions.update');
    Route::delete('professions/{id}', [ProfessionController::class, 'destroy'])->name('api.v1.professions.destroy');

    //Rutas para Appointment
    Route::get('appointments', [AppointmentController::class, 'index'])->name('api.v1.appointments.index');
    Route::post('appointments', [AppointmentController::class, 'store'])->name('api.v1.appointments.store');
    Route::get('appointments/{id}', [AppointmentController::class, 'show'])->name('api.v1.appointments.show');
    Route::put('appointments/{id}', [AppointmentController::class, 'update'])->name('api.v1.appointments.update');
    Route::delete('appointments/{id}', [AppointmentController::class, 'destroy'])->name('api.v1.appointments.destroy');
    
    //Rutas para Review
    Route::get('reviews', [ReviewController::class, 'index'])->name('api.v1.reviews.index');
    Route::post('reviews', [ReviewController::class, 'store'])->name('api.v1.reviews.store');
    Route::get('reviews/{id}', [ReviewController::class, 'show'])->name('api.v1.reviews.show');
    Route::put('reviews/{id}', [ReviewController::class, 'update'])->name('api.v1.reviews.update');
    Route::delete('reviews/{id}', [ReviewController::class, 'destroy'])->name('api.v1.reviews.destroy');

    //Rutas para Bill
    Route::get('bills', [BillController::class, 'index'])->name('api.v1.bills.index');
    Route::post('bills', [BillController::class, 'store'])->name('api.v1.bills.store');
    Route::get('bills/{id}', [BillController::class, 'show'])->name('api.v1.bills.show');
    Route::put('bills/{id}', [BillController::class, 'update'])->name('api.v1.bills.update');
    Route::delete('bills/{id}', [BillController::class, 'destroy'])->name('api.v1.bills.destroy');

    //Rutas para MethodPayment
    Route::get('method-payments', [MethodPaymentController::class, 'index'])->name('api.v1.method-payments.index');
    Route::post('method-payments', [MethodPaymentController::class, 'store'])->name('api.v1.method-payments.store');
    Route::get('method-payments/{id}', [MethodPaymentController::class, 'show'])->name('api.v1.method-payments.show');
    Route::put('method-payments/{id}', [MethodPaymentController::class, 'update'])->name('api.v1.method-payments.update');
    Route::delete('method-payments/{id}', [MethodPaymentController::class, 'destroy'])->name('api.v1.method-payments.destroy');

    //Rutas para Bank
    Route::get('banks', [BankController::class, 'index'])->name('api.v1.banks.index');
    Route::post('banks', [BankController::class, 'store'])->name('api.v1.banks.store');
    Route::get('banks/{id}', [BankController::class, 'show'])->name('api.v1.banks.show');
    Route::put('banks/{id}', [BankController::class, 'update'])->name('api.v1.banks.update');
    Route::delete('banks/{id}', [BankController::class, 'destroy'])->name('api.v1.banks.destroy');

    //Rutas para Resource
    Route::get('resources', [ResourceController::class, 'index'])->name('api.v1.resources.index');
    Route::post('resources', [ResourceController::class, 'store'])->name('api.v1.resources.store');
    Route::get('resources/{id}', [ResourceController::class, 'show'])->name('api.v1.resources.show');
    Route::put('resources/{id}', [ResourceController::class, 'update'])->name('api.v1.resources.update');
    Route::delete('resources/{id}', [ResourceController::class, 'destroy'])->name('api.v1.resources.destroy');

    //Rutas para Message
    Route::get('messages', [MessageController::class, 'index'])->name('api.v1.messages.index');
    Route::post('messages', [MessageController::class, 'store'])->name('api.v1.messages.store');
    Route::get('messages/{id}', [MessageController::class, 'show'])->name('api.v1.messages.show');
    Route::put('messages/{id}', [MessageController::class, 'update'])->name('api.v1.messages.update');
    Route::delete('messages/{id}', [MessageController::class, 'destroy'])->name('api.v1.messages.destroy');

    //Rutas para Chat
    Route::get('chats', [ChatController::class, 'index'])->name('api.v1.chats.index');
    Route::post('chats', [ChatController::class, 'store'])->name('api.v1.chats.store');
    Route::get('chats/{id}', [ChatController::class, 'show'])->name('api.v1.chats.show');
    Route::put('chats/{id}', [ChatController::class, 'update'])->name('api.v1.chats.update');
    Route::delete('chats/{id}', [ChatController::class, 'destroy'])->name('api.v1.chats.destroy');

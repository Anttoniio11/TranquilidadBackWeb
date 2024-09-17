<?php

use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::apiResource('usuarios', UserController::class);

//Route::get('usuarios', [UserController::class, 'index']); // Obtener todos los usuarios
//Route::get('usuarios/{id}', [UserController::class, 'show']); // Obtener un usuario por ID
//Route::post('usuarios', [UserController::class, 'store']); // Crear un nuevo usuario
//Route::put('usuarios/{id}', [UserController::class, 'update']); // Actualizar un usuario
//Route::delete('usuarios/{id}', [UserController::class, 'destroy']); // Eliminar un usuario

//Rutas para perfiles
Route::get('perfiles', [PerfilController::class, 'index']); // Obtener todos los perfiles
Route::get('perfiles/{id}', [PerfilController::class, 'show']); // Obtener un perfil por ID
Route::post('perfiles', [PerfilController::class, 'store']); // Crear un nuevo perfil
Route::put('perfiles/{id}', [PerfilController::class, 'update']); // Actualizar un perfil
Route::delete('perfiles/{id}', [PerfilController::class, 'destroy']); // Eliminar un perfil

// Rutas para Usuarios
Route::get('usuarios', [UserController::class, 'index']); // Obtener todos los usuarios
Route::post('usuarios', [UserController::class, 'store']); // Crear un nuevo usuario
Route::get('usuarios/{id}', [UserController::class, 'show']); // Mostrar un usuario específico
Route::put('usuarios/{id}', [UserController::class, 'update']); // Actualizar un usuario
Route::delete('usuarios/{id}', [UserController::class, 'destroy']); // Eliminar un usuario


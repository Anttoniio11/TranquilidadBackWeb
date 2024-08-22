<?php
use App\Http\Controllers\Api\CarpetaController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* esta es una forma de agrupar rutas
Route::controller(UserController::class)->group(function(){
    Route::post('users', 'store')->name('api.v1.users.store');
    Route::get('users', 'index')->name('api.v1.users.index');
    Route::get('users/{user}', 'show')->name('api.v1.users.show');
    Route::put('users/{user}', 'update')->name('api.v1.users.update');
    Route::delete('users/{user}', 'destroy')->name('api.v1.users.delete');
});
*/


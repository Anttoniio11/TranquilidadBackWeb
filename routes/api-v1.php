<?php
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\CompartidoController;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PincelController;
use App\Http\Controllers\Api\PinturaController;
use App\Http\Controllers\Api\PlantillaController;
use App\Http\Controllers\Api\PublicacionController;
use App\Models\Plantilla;

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
/*
Route::get('pincels', [PincelController::class,'index'])->name('api.v1.pincels.index');
Route::post('pincels', [PincelController::class,'store'])->name('api.v1.pincels.store');

Route::controller(CategoriaController::class)->group(function(){
    Route::post('categories', 'store')->name('api.v1.categories.store');
    Route::get('categories', 'index')->name('api.v1.categories.index');
    Route::put('categories/{categorie}', 'update')->name('api.v1.categories.update');
    Route::get('categories/{categorie}', 'show')->name('api.v1.categories.show');
    Route::delete('categories/{categorie}', 'destroy')->name('api.v1.categories.delete');
});

Route::controller(CompartidoController::class)->group(function(){
    Route::post('shared', 'store')->name('api.v1.shared.store');
    Route::get('shared', 'index')->name('api.v1.shared.index');
    Route::put('shared/{shared}', 'update')->name('api.v1.shared.update');
    Route::get('shared/{shared}', 'show')->name('api.v1.shared.show');
    Route::delete('shared/{shared}', 'destroy')->name('api.v1.shared.delete');
});

/* Route::controller(PlantillaController::class)->group(function(){
    Route::post('templates', 'store')->name('api.v1.templates.store');
    Route::get('templates', 'index')->name('api.v1.templates.index');
    Route::put('templates/{templates}', 'update')->name('api.v1.templates.update');
    Route::get('templates/{templates}', 'show')->name('api.v1.templates.show');
    Route::delete('templates/{templates}', 'destroy')->name('api.v1.templates.delete');
}); */

Route::controller(PinturaController::class)->group(function(){
    Route::post('paints', 'store')->name('api.v1.paints.store');
    Route::get('paints', 'index')->name('api.v1.paints.index');
    Route::put('paints/{paint}', 'update')->name('api.v1.paints.update');
    Route::get('paints/{paint}', 'show')->name('api.v1.paints.show');
    Route::delete('paints/{paint}', 'destroy')->name('api.v1.paints.delete');
});

Route::controller(CompartidoController::class)->group(function(){
    Route::post('shared', 'store')->name('api.v1.shared.store');
    Route::get('shared', 'index')->name('api.v1.shared.index');
    Route::put('shared/{shared}', 'update')->name('api.v1.shared.update');
    Route::get('shared/{shared}', 'show')->name('api.v1.shared.show');
    Route::delete('shared/{shared}', 'destroy')->name('api.v1.shared.delete');
});

Route::controller(PlantillaController::class)->group(function(){
    Route::post('templates', 'store')->name('api.v1.templates.store');
    Route::get('templates', 'index')->name('api.v1.templates.index');
    Route::put('templates/{templates}', 'update')->name('api.v1.templates.update');
    Route::get('templates/{templates}', 'show')->name('api.v1.templates.show');
    Route::delete('templates/{templates}', 'destroy')->name('api.v1.templates.delete');
});
*/

Route::prefix('api/v1')->group(function(){

    Route::apiResource('publicaciones', PublicacionController::class);
});

<?php

use App\Http\Controllers\Api\ApiAlimentacion\FoodController;
use App\Http\Controllers\Api\ApiAlimentacion\HealthPlanController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //return $request->user();
//});

Route::get('search/{food}', [FoodController::class, 'show']);

Route::get('healthplan', [HealthPlanController::class,'index'])->name('api.v1.HealthPlan.index');
 Route::post('healthplan', [HealthPlanController::class,'store'])->name('api.v1.HealthPlan.store');
 Route::get('healthplan/{id}', [HealthPlanController::class,'show'])->name('api.v1.HealthPlan.show');
 Route::put('healthplan/{info}', [HealthPlanController::class,'update'])->name('api.v1.HealthPlan.update');
 Route::delete('healthplan/{id}', [HealthPlanController::class,'destroy'])->name('api.v1.HealthPlan.delete');
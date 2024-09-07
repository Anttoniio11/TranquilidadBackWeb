<?php

use App\Http\Controllers\Api\ApiAlimentacion\FoodController;
use App\Http\Controllers\Api\ApiAlimentacion\HealthPlanController;
use App\Http\Controllers\Api\ApiAlimentacion\QuestionnaireController;
use App\Http\Controllers\Api\ApiAlimentacion\ResultController;
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

//rutas alimentacion
Route::get('search/{food}', [FoodController::class, 'show']);

//rutas plan bienestar
Route::get('healthplan', [HealthPlanController::class,'index'])->name('api.v1.healthplan.index');
 Route::post('healthplan', [HealthPlanController::class,'store'])->name('api.v1.healthplan.store');
 Route::get('healthplan/{id}', [HealthPlanController::class,'show'])->name('api.v1.healthplan.show');
 Route::put('healthplan/{info}', [HealthPlanController::class,'update'])->name('api.v1.healthplan.update');
 Route::delete('healthplan/{info}', [HealthPlanController::class,'destroy'])->name('api.v1.healthplan.delete');

 //rutas questionario
 Route::get('cuestionario', [QuestionnaireController::class,'index'])->name('api.v1.questionnaire.index');
 Route::post('cuestionario', [QuestionnaireController::class,'store'])->name('api.v1.questionnaire.store');
 Route::get('cuestionario/{id}', [QuestionnaireController::class,'show'])->name('api.v1.questionnaire.show');
 Route::put('cuestionario/{info}', [QuestionnaireController::class,'update'])->name('api.v1.questionnaire.update');
 Route::delete('cuestionario/{info}', [QuestionnaireController::class,'destroy'])->name('api.v1.questionnaire.delete');

 //rutas resultados
 Route::post('resultados/{questionnaireId}', [ResultController::class,'store'])->name('api.v1.results.store');

 //rutas recomendation

 //rutas forum 

 //rutas personalGoal

 //rutas processLog


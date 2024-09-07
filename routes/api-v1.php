<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAlimentacion\FoodController;
use App\Http\Controllers\Api\ApiAlimentacion\ForumController;
use App\Http\Controllers\Api\ApiAlimentacion\HealthPlanController;
use App\Http\Controllers\Api\ApiAlimentacion\PersonalGoalController;
use App\Http\Controllers\Api\ApiAlimentacion\ProcessLogController;
use App\Http\Controllers\Api\ApiAlimentacion\RecommendationController;

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

//rutas foro

Route::get('forums', [ForumController::class, 'index'])->name('api.v1.forums.index');
Route::post('forums', [ForumController::class, 'store'])->name('api.v1.forums.store');
Route::get('forums/{id}', [ForumController::class, 'show'])->name('api.v1.forums.show');
Route::put('forums/{id}', [ForumController::class, 'update'])->name('api.v1.forums.update');
Route::delete('forums/{id}', [ForumController::class, 'destroy'])->name('api.v1.forums.destroy');

<<<<<<< HEAD
 //rutas resultados
 Route::get('resultados', [ResultController::class,'index'])->name('api.v1.result.index');
 Route::post('resultados', [ResultController::class,'store'])->name('api.v1.results.store');
 Route::post('resultados/{idQ}/{idU}', [ResultController::class, 'create'])->name('api.v1.result.create');
 Route::get('resultados/{id}', [QuestionnaireController::class,'show'])->name('api.v1.result.show');
 Route::put('resultados/{info}', [QuestionnaireController::class,'update'])->name('api.v1.resultados.update');
 Route::delete('resultados/{info}', [QuestionnaireController::class,'destroy'])->name('api.v1.questionnaire.delete');
=======
//rutas para healthP
>>>>>>> eef1320da1a479ff4b21e0728f837d267bce268f

Route::get('health-plans', [HealthPlanController::class, 'index'])->name('api.v1.healthPlans.index');
Route::post('health-plans', [HealthPlanController::class, 'store'])->name('api.v1.healthPlans.store');
Route::get('health-plans/{id}', [HealthPlanController::class, 'show'])->name('api.v1.healthPlans.show');
Route::put('health-plans/{id}', [HealthPlanController::class, 'update'])->name('api.v1.healthPlans.update');
Route::delete('health-plans/{id}', [HealthPlanController::class, 'destroy'])->name('api.v1.healthPlans.destroy');

<<<<<<< HEAD
//rutas forum 

//rutas personalGoal

//rutas processLog
=======
//rutas personalGoal

Route::get('personal-goals', [PersonalGoalController::class, 'index'])->name('api.v1.personalGoals.index');
Route::post('personal-goals', [PersonalGoalController::class, 'store'])->name('api.v1.personalGoals.store');
Route::get('personal-goals/{id}', [PersonalGoalController::class, 'show'])->name('api.v1.personalGoals.show');
Route::put('personal-goals/{id}', [PersonalGoalController::class, 'update'])->name('api.v1.personalGoals.update');
Route::delete('personal-goals/{id}', [PersonalGoalController::class, 'destroy'])->name('api.v1.personalGoals.destroy');

//rutas processLog

Route::get('process-logs', [ProcessLogController::class, 'index'])->name('api.v1.processLogs.index');
Route::post('process-logs', [ProcessLogController::class, 'store'])->name('api.v1.processLogs.store');
Route::get('process-logs/{id}', [ProcessLogController::class, 'show'])->name('api.v1.processLogs.show');
Route::put('process-logs/{id}', [ProcessLogController::class, 'update'])->name('api.v1.processLogs.update');
Route::delete('process-logs/{id}', [ProcessLogController::class, 'destroy'])->name('api.v1.processLogs.destroy');

//rutas para recomendation

Route::get('recommendations', [RecommendationController::class, 'index'])->name('api.v1.recommendations.index');
Route::post('recommendations', [RecommendationController::class, 'store'])->name('api.v1.recommendations.store');
Route::get('recommendations/{id}', [RecommendationController::class, 'show'])->name('api.v1.recommendations.show');
Route::put('recommendations/{id}', [RecommendationController::class, 'update'])->name('api.v1.recommendations.update');
Route::delete('recommendations/{id}', [RecommendationController::class, 'destroy'])->name('api.v1.recommendations.destroy');
>>>>>>> eef1320da1a479ff4b21e0728f837d267bce268f


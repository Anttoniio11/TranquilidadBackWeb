<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAlimentacion\FoodController;
use App\Http\Controllers\Api\ApiAlimentacion\ForumController;
use App\Http\Controllers\Api\ApiAlimentacion\PersonalGoalController;
use App\Http\Controllers\Api\ApiAlimentacion\ProcessLogController;
use App\Http\Controllers\Api\ApiAlimentacion\RecommendationController;
use App\Http\Controllers\Api\ApiAlimentacion\ResultController;
use App\Http\Controllers\Api\ApiAlimentacion\QuestionnaireController;
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

//rutas questionario
Route::get('cuestionario', [QuestionnaireController::class, 'index'])->name('api.v1.questionnaire.index');
Route::post('cuestionario', [QuestionnaireController::class, 'store'])->name('api.v1.questionnaire.store');
Route::get('cuestionario/{id}', [QuestionnaireController::class, 'show'])->name('api.v1.questionnaire.show');
Route::put('cuestionario/{id}', [QuestionnaireController::class, 'update'])->name('api.v1.questionnaire.update');
Route::delete('cuestionario/{info}', [QuestionnaireController::class, 'destroy'])->name('api.v1.questionnaire.delete');

//rutas resultados
Route::get('resultados', [ResultController::class, 'index'])->name('api.v1.result.index');
Route::post('resultados', [ResultController::class, 'store'])->name('api.v1.results.store');
Route::post('resultados/{idU}/{idQ}', [ResultController::class, 'create'])->name('api.v1.result.create');
Route::get('resultados/{id}', [ResultController::class, 'show'])->name('api.v1.result.show');
Route::put('resultados/{idU}/{idQ}/{idR}', [ResultController::class, 'update'])->name('api.v1.result.update');
Route::delete('resultados/{info}', [ResultController::class, 'destroy'])->name('api.v1.result.delete');

//rutas para recomendation
Route::get('recommendations', [RecommendationController::class, 'index'])->name('api.v1.recommendations.index');
Route::post('recommendations', [RecommendationController::class, 'store'])->name('api.v1.recommendations.store');
Route::post('recommendations/{idR}', [RecommendationController::class, 'create'])->name('api.v1.recommendations.store');
Route::get('recommendations/{id}', [RecommendationController::class, 'show'])->name('api.v1.recommendations.show');
Route::put('recommendations/{id}', [RecommendationController::class, 'update'])->name('api.v1.recommendations.update');
Route::delete('recommendations/{id}', [RecommendationController::class, 'destroy'])->name('api.v1.recommendations.destroy');

//rutas foro
Route::get('forums', [ForumController::class, 'index'])->name('api.v1.forums.index');
Route::post('forums', [ForumController::class, 'store'])->name('api.v1.forums.store');
Route::get('forums/{id}', [ForumController::class, 'show'])->name('api.v1.forums.show');
Route::put('forums/{id}', [ForumController::class, 'update'])->name('api.v1.forums.update');
Route::delete('forums/{id}', [ForumController::class, 'destroy'])->name('api.v1.forums.destroy');

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
Route::post('recommendations/{idR}', [RecommendationController::class, 'create'])->name('api.v1.recommendations.store');
Route::get('recommendations/{id}', [RecommendationController::class, 'show'])->name('api.v1.recommendations.show');
Route::put('recommendations/{id}', [RecommendationController::class, 'update'])->name('api.v1.recommendations.update');
Route::delete('recommendations/{id}', [RecommendationController::class, 'destroy'])->name('api.v1.recommendations.destroy');

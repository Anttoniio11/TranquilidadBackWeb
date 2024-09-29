<?php
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\arteTerapia\CategoryController;
use App\Http\Controllers\Api\arteTerapia\TemplateController;
use App\Http\Controllers\Api\arteTerapia\PaintingController;
use App\Http\Controllers\Api\arteTerapia\DrawingController;
use App\Http\Controllers\Api\arteTerapia\GalleryController;
use App\Http\Controllers\Api\arteTerapia\PublicationController;

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

Route::get('/', function () {
    return view('welcome');
});
//check category
Route::controller(CategoryController::class)->group(function(){
    Route::post('categories', 'store')->name('api.v1.categories.store');
    Route::get('categories', 'index')->name('api.v1.categories.index');
    Route::get('categories/{category}', 'show')->name('api.v1.categories.show');
    Route::put('categories/{category}', 'update')->name('api.v1.categories.update');
    Route::delete('categories/{category}', 'destroy')->name('api.v1.categories.delete');
});


Route::controller(TemplateController::class)->group(function(){
    Route::post('templates', 'store')->name('api.v1.templates.store');
    Route::get('templates', 'index')->name('api.v1.templates.index');
    Route::get('templates/{id}', 'show')->name('api.v1.templates.show');
    Route::put('templates/{id}', 'update')->name('api.v1.templates.update');
    Route::delete('templates/{id}', 'destroy')->name('api.v1.templates.delete');
});

Route::controller(PaintingController::class)->group(function(){
    Route::post('paintings', 'store')->name('api.v1.paintings.store');
    Route::get('paintings', 'index')->name('api.v1.paintings.index');
    Route::get('paintings/{painting}', 'show')->name('api.v1.paintings.show');
    Route::put('paintings/{painting}', 'update')->name('api.v1.paintings.update');
    Route::delete('paintings/{painting}', 'destroy')->name('api.v1.paintings.delete');
});

Route::controller(DrawingController::class)->group(function(){
    Route::post('drawings', 'store')->name('api.v1.drawings.store');
    Route::get('drawings', 'index')->name('api.v1.drawings.index');
    Route::get('drawings/{drawing}', 'show')->name('api.v1.drawings.show');
    Route::put('drawings/{drawing}', 'update')->name('api.v1.drawings.update');
    Route::delete('drawings/{drawing}', 'destroy')->name('api.v1.drawings.delete');
});

Route::controller(GalleryController::class)->group(function(){
    Route::post('galleries', 'store')->name('api.v1.galleries.store');
    Route::get('galleries', 'index')->name('api.v1.galleries.index');
    Route::get('galleries/{gallery}', 'show')->name('api.v1.galleries.show');
    Route::put('galleries/{gallery}', 'update')->name('api.v1.galleries.update');
    Route::delete('galleries/{gallery}', 'destroy')->name('api.v1.galleries.delete');
});

Route::controller(PublicationController::class)->group(function(){
    Route::post('publications', 'store')->name('api.v1.publications.store');
    Route::get('publications', 'index')->name('api.v1.publications.index');
    Route::get('publications/{publication}', 'show')->name('api.v1.publications.show');
    Route::put('publications/{publication}', 'update')->name('api.v1.publications.update');
    Route::delete('publications/{publication}', 'destroy')->name('api.v1.publications.delete');
});

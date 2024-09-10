<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PodcastController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});


Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
Route::get('/genres/{id}', [GenreController::class, 'show'])->name('genres.show');

Route::get('albums', [AlbumController::class, 'index'])->name('albums.index');
Route::get('album/{id}', [AlbumController::class, 'show'])->name('album.show');

Route::get('audios', [AudioController::class, 'index'])->name('audios.index');
Route::get('audio/{id}', [AudioController::class, 'show'])->name('audio.show');

Route::get('/podcasts', [PodcastController::class, 'index'])->name('podcasts.index');
Route::get('/podcast/{id}', [PodcastController::class, 'show'])->name('podcasts.show');
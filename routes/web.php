<?php

use App\Http\Controllers\MovieTubeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MovieTubeController::class, 'index']);
Route::get('/movies', [MovieTubeController::class, 'movies']);
Route::get('/tv-shows', [MovieTubeController::class, 'tvshows']);
Route::get('/search', [MovieTubeController::class, 'search']);
Route::get('/movie/{id}', [MovieTubeController::class, 'moviesDetail']);
Route::get('/tv/{id}', [MovieTubeController::class, 'tvShowDetail']);

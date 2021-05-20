<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post( '/register', \App\Http\Controllers\Auth\RegisterController::class )->name('register');
Route::post( '/login', \App\Http\Controllers\Auth\LoginController::class )->name('login');

Route::middleware( 'auth:api' )->group( function () {
    Route::put( '/user/profile', \App\Http\Controllers\Auth\ProfileController::class )->name('profile');

    Route::resource('/planets', \App\Http\Controllers\Api\PlanetController::class )->only('index', 'show');
    Route::resource('/films', \App\Http\Controllers\Api\FilmController::class )->only('index', 'show');
} );

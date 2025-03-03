<?php

use App\Http\Controllers\api\ActorController;
use App\Http\Controllers\api\AddressController;
use App\Http\Controllers\api\CountryController;
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

Route::prefix('v3')->group(function () {

    // Authors CRUD
    Route::prefix('author')->controller(ActorController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/new', 'store');
        Route::put('/update/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Address CRUD
    Route::prefix('address')->controller(AddressController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/new', 'store');
        Route::put('/update/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Conutry CRUD
    Route::prefix('country')->controller(CountryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/new', 'store');
        Route::put('/update/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
    });
});

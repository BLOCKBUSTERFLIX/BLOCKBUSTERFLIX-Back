<?php

use App\Http\Controllers\api\ActorController;
use App\Http\Controllers\api\AddressController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\CityController;
use App\Http\Controllers\api\CountryController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\FilmController;
use App\Http\Controllers\api\InventoryController;
use App\Http\Controllers\api\LanguageController;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\RentalController;
use App\Http\Controllers\api\StaffController;
use App\Http\Controllers\api\StoreController;
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

    //Rutas resource
    /* 
        api/v3
        POST: /name/new
        PUT: name/update/:id
        GET: name/:id
        GET: name/
        DELETE: name/:id

    */
    Route::resource('actor',  ActorController::class);
    Route::resource('country',  CountryController::class);
    Route::resource('languages',  LanguageController::class);
    Route::resource('films',  FilmController::class);
    Route::resource('city',  CityController::class);
    Route::resource('address', AddressController::class);
    Route::resource('store',  StoreController::class);
    Route::resource('staff',  StaffController::class);

    // Category CRUD
    Route::prefix('category')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/new', 'store');
        Route::put('/update/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Customer CRUD
    Route::prefix('customer')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/new', 'store');
        Route::put('/update/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Inventory CRUD
    Route::prefix('inventory')->controller(InventoryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/new', 'store');
        Route::put('/update/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Payment CRUD
    Route::prefix('payment')->controller(PaymentController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/new', 'store');
        Route::put('/update/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Rental CRUD
    Route::prefix('rental')->controller(RentalController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/new', 'store');
        Route::put('/update/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Staff CRUD
    Route::prefix('staff')->controller(StaffController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/new', 'store');
        Route::put('/update/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Store CRUD
    Route::prefix('store')->controller(StoreController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/new', 'store');
        Route::put('/update/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', 'destroy')->where('id', '[0-9]+');
    });
});

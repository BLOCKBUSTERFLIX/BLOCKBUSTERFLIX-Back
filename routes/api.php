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
use App\Http\Controllers\api\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

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
        URL: http://127.0.0.1:8000/api/v3
        POST: /{name}/new
        PUT: {name}/update/:id
        GET: {name}/:id
        GET: {name}/
        DELETE: {name}/:id
    */
    Route::resource('actors',  ActorController::class);
    Route::resource('payments',  PaymentController::class);
    Route::resource('countries',  CountryController::class);
    Route::resource('languages',  LanguageController::class);
    Route::resource('films',  FilmController::class);
    Route::resource('cities',  CityController::class);
    Route::resource('addresses', AddressController::class);
    Route::resource('stores',  StoreController::class);
    Route::resource('staff',  StaffController::class);

    // Categories CRUD
    Route::prefix('categories')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Customers CRUD
    Route::prefix('customers')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Inventories CRUD
    Route::prefix('inventories')->controller(InventoryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Payments CRUD
    Route::prefix('payments')->controller(PaymentController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Rentals CRUD
    Route::prefix('rentals')->controller(RentalController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Staffs CRUD
    Route::prefix('staff')->controller(StaffController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'destroy')->where('id', '[0-9]+');
    });

    // Stores CRUD
    Route::prefix('stores')->controller(StoreController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->where('id', '[0-9]+');
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->where('id', '[0-9]+');
        Route::delete('/{id}', 'destroy')->where('id', '[0-9]+');
    });

    Route::get('table/{name}', function ($name) {
        return array_filter(Schema::getColumnListing($name), function ($column) {
            return !in_array($column, ['created_at', 'updated_at']);
        });
    });

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::post('logout', 'logout');
            Route::post('refresh', 'refresh');
            Route::get('info', 'me');
        });
        Route::post('login', 'login');
    });
});

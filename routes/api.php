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
use App\Http\Controllers\api\EmailController;
use App\Http\Controllers\api\RoleController;
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
    Route::middleware(['auth:api'])->group(function () {
        Route::get('actors', [ActorController::class, 'index'])->middleware(['role:1,2,3']);
        Route::get('actors/{id}', [ActorController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1,2,3']);
        Route::post('actors', [ActorController::class, 'store'])->middleware(['role:1,2']);
        Route::put('actors/{id}', [ActorController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1,2']);
        Route::delete('actors/{id}', [ActorController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1,2']);
        
        Route::get('films', [FilmController::class, 'index'])->middleware(['role:1,2,3']);
        Route::get('films/{id}', [FilmController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1,2,3']);
        Route::post('films', [FilmController::class, 'store'])->middleware(['role:1,2']);
        Route::put('films/{id}', [FilmController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1,2']);
        Route::delete('films/{id}', [FilmController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1,2']);
        
        Route::get('payments', [PaymentController::class, 'index'])->middleware(['role:1,3']);
        Route::get('payments/{id}', [PaymentController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1,3']);
        Route::post('payments', [PaymentController::class, 'store'])->middleware(['role:1']);
        Route::put('payments/{id}', [PaymentController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1']);
        Route::delete('payments/{id}', [PaymentController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1']);
        
        Route::get('countries', [CountryController::class, 'index'])->middleware(['role:1,3']);
        Route::get('countries/{id}', [CountryController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1,3']);
        Route::post('countries', [CountryController::class, 'store'])->middleware(['role:1']);
        Route::put('countries/{id}', [CountryController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1']);
        Route::delete('countries/{id}', [CountryController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1']);
        
        Route::get('languages', [LanguageController::class, 'index'])->middleware(['role:1']);
        Route::get('languages/{id}', [LanguageController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1']);
        Route::post('languages', [LanguageController::class, 'store'])->middleware(['role:1']);
        Route::put('languages/{id}', [LanguageController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1']);
        Route::delete('languages/{id}', [LanguageController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1']);
        
        Route::get('cities', [CityController::class, 'index'])->middleware(['role:1,3']);
        Route::get('cities/{id}', [CityController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1,3']);
        Route::post('cities', [CityController::class, 'store'])->middleware(['role:1']);
        Route::put('cities/{id}', [CityController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1']);
        Route::delete('cities/{id}', [CityController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1']);
        
        Route::get('addresses', [AddressController::class, 'index'])->middleware(['role:1,3']);
        Route::get('addresses/{id}', [AddressController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1,3']);
        Route::post('addresses', [AddressController::class, 'store'])->middleware(['role:1']);
        Route::put('addresses/{id}', [AddressController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1']);
        Route::delete('addresses/{id}', [AddressController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1']);
        
        Route::get('stores', [StoreController::class, 'index'])->middleware(['role:1,3']);
        Route::get('stores/{id}', [StoreController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1,3']);
        Route::post('stores', [StoreController::class, 'store'])->middleware(['role:1']);
        Route::put('stores/{id}', [StoreController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1']);
        Route::delete('stores/{id}', [StoreController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1']);
        
        Route::get('staff', [StaffController::class, 'index'])->middleware(['role:1,3']);
        Route::get('staff/{id}', [StaffController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1,3']);
        Route::post('staff', [StaffController::class, 'store'])->middleware(['role:1']);
        Route::put('staff/{id}', [StaffController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1']);
        Route::delete('staff/{id}', [StaffController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1']);
        
        Route::get('categories', [CategoryController::class, 'index'])->middleware(['role:1,2,3']);
        Route::get('categories/{id}', [CategoryController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1,2,3']);
        Route::post('categories', [CategoryController::class, 'store'])->middleware(['role:1,2']);
        Route::put('categories/{id}', [CategoryController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1,2']);
        Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1,2']);

        Route::get('inventories', [InventoryController::class, 'index'])->middleware(['role:1,2,3']);
        Route::get('inventories/{id}', [InventoryController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1,2,3']);
        Route::post('inventories', [InventoryController::class, 'store'])->middleware(['role:1,2']);
        Route::put('inventories/{id}', [InventoryController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1,2']);
        Route::delete('inventories/{id}', [InventoryController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1,2']);

        Route::get('rentals', [RentalController::class, 'index'])->middleware(['role:1,2,3']);
        Route::get('rentals/{id}', [RentalController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1,2,3']);
        Route::post('rentals', [RentalController::class, 'store'])->middleware(['role:1,2']);
        Route::put('rentals/{id}', [RentalController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1,2']);
        Route::delete('rentals/{id}', [RentalController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1,2']);

        Route::get('customers', [CustomerController::class, 'index'])->middleware(['role:1,3']);
        Route::get('customers/{id}', [CustomerController::class, 'show'])->where('id', '[0-9]+')->middleware(['role:1,3']);
        Route::post('customers', [CustomerController::class, 'store'])->middleware(['role:1']);
        Route::put('customers/{id}', [CustomerController::class, 'update'])->where('id', '[0-9]+')->middleware(['role:1']);
        Route::delete('customers/{id}', [CustomerController::class, 'destroy'])->where('id', '[0-9]+')->middleware(['role:1']);
    
        Route::get('roles', [RoleController::class, 'index'])->middleware(['role:1']);

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
        Route::post('login', 'login')->name('auth.login');
        Route::post('verify-2fa', [AuthController::class, 'verifyTwoFactor']);
        
        Route::resource('staff',  StaffController::class);

        Route::post('recovery-account-code', 'sendResetCode');
        Route::post('recovery-account-verification', 'verifyResetCode');
        Route::post('recovery-account', 'resetPassword');

    });
});

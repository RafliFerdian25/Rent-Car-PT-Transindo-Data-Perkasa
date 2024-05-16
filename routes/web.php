<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RentController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// Auth
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('login.authenticate');
});

// register
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'create')->name('register');
    Route::post('/register', 'store')->name('register.store');
});

Route::group(['middleware' => ['auth']], function () {
    Route::controller(CarController::class)->group(function () {
        Route::get('/car', 'index')->name('car.index');
        Route::get('/car/data', 'getcar')->name('car.data');
        Route::get('/car/category/data', 'getCategories')->name('car.category.data');
        Route::get('/car/create', 'create')->name('car.create');
        Route::post('/car', 'store')->name('car.store');
        Route::get('/car/{car:id}/edit', 'edit')->name('car.edit');
        Route::put('/car/{car:id}', 'update')->name('car.update');
        Route::delete('/car/{car:id}', 'destroy')->name('car.destroy');
    });

    Route::controller(RentController::class)->group(function () {
        Route::get('/', 'index')->name('rent.car.index');
    });
});

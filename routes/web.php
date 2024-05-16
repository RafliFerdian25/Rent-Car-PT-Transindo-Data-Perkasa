<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RentController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// Auth
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('login.authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

// register
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'create')->name('register');
    Route::post('/register', 'store')->name('register.store');
});

Route::group(['middleware' => ['auth']], function () {
    // admin
    Route::middleware(['checkRole:admin'])->group(function () {
        Route::controller(CarController::class)->group(function () {
            Route::get('/car/create', 'create')->name('car.create');
            Route::post('/car', 'store')->name('car.store');
            Route::get('/car/{car:id}/edit', 'edit')->name('car.edit');
            Route::put('/car/{car:id}', 'update')->name('car.update');
        });
    });

    Route::controller(CarController::class)->group(function () {
        Route::get('/', 'index')->name('car.index');
        Route::get('/car/data', 'getcar')->name('car.data');
        Route::get('/car/category/data', 'getCategories')->name('car.category.data');
        Route::delete('/car/{car:id}', 'destroy')->name('car.destroy');
    });


    Route::middleware(['checkRole:customer'])->group(function () {
        Route::controller(RentController::class)->group(function () {
            Route::get('/rent', 'index')->name('rent.index');
            Route::get('/rent/history', 'history')->name('rent.history');
            Route::get('/rent/create', 'create')->name('rent.create');
            Route::post('/rent', 'store')->name('rent.store');
        });
    });
});

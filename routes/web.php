<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


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
        Route::get('/admin/book', 'book')->name('admin.book');
        Route::get('/admin/book/data', 'getBook')->name('admin.book.data');
        Route::get('/admin/book/category/data', 'getCategories')->name('admin.book.category.data');
        Route::get('/admin/ebook', 'ebook')->name('admin.ebook');
        Route::get('/admin/ebook/data', 'getEbook')->name('admin.ebook.data');
        Route::get('/admin/book/create', 'create')->name('admin.book.create');
        Route::get('/admin/book/{book:id}/edit', 'edit')->name('admin.book.edit');
        Route::put('/admin/book/{book:id}', 'update')->name('admin.book.update');
        Route::post('/admin/book', 'store')->name('admin.book.store');
        Route::delete('/admin/book/{book:id}', 'destroy')->name('admin.book.destroy');
    });
});

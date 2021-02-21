<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use App\Http\Controllers\User\BookController;

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

Route::get('/', [App\Http\Controllers\Guest\BookController::class, 'index']);

Route::group(['prefix' => 'guest', 'as' => 'guest.'], function(){
    Route::resource('books', Guest\BookController::class);
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::put('user/profile-information', [ProfileInformationController::class, 'update'])
            ->name('user-profile-information.update');
        Route::put('user/password', [PasswordController::class, 'update'])
            ->name('user-password.update');
        Route::resource('users', User\UserController::class);
        Route::resource('reviews', User\ReviewController::class);
        Route::resource('books', User\BookController::class, ['only' => ['index', 'create', 'store']]);
        Route::group(['middleware' => 'auth.accessNotApproved'], function(){
            Route::resource('books', User\BookController::class, ['only' => ['show']]);
        });
        Route::group(['middleware' => 'auth.accessBookOwner'], function(){
            Route::resource('books', User\BookController::class, ['only' => ['edit', 'update', 'destroy']]);
        });
        Route::post('books/report/{book}', [BookController::class, 'report'])->name('books.report');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
        Route::group(['middleware' => 'auth.accessAdmin'], function(){
            Route::resource('books', Admin\BookController::class);
        });
    });
});












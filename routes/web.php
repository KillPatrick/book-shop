<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;

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

Route::get('/', [App\Http\Controllers\User\BookController::class, 'index']);



Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::put('user/profile-information', [ProfileInformationController::class, 'update'])
            ->name('user-profile-information.update');
        Route::put('user/password', [PasswordController::class, 'update'])
            ->name('user-password.update');
        Route::resource('users', User\UserController::class);
        Route::resource('reviews', User\ReviewController::class);
        Route::group(['middleware' => 'accessNotApproved'], function(){
            Route::resource('books', User\BookController::class, ['only' => ['show']]);
        });
        Route::resource('books', User\BookController::class, ['only' => ['create', 'store']]);
        Route::group(['middleware' => 'auth.accessBookOwner'], function(){
            //Route::resource('books', User\BookController::class);
            Route::resource('books', User\BookController::class, ['only' => ['edit', 'update', 'delete']]);
        });
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
        Route::group(['middleware' => 'auth.accessAdmin'], function(){
            Route::resource('books', Admin\BookController::class);
        });
    });
});

Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
    Route::resource('books', User\BookController::class, ['except' => ['show', 'edit', 'update', 'delete', 'create', 'store']]);
});
Route::group(['middleware' => 'accessNotApproved'], function(){
    Route::resource('books', User\BookController::class, ['only' => ['show']]);
});










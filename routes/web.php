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

Route::get('/', [\App\Http\Controllers\BookController::class, 'index']);

//Route::view('home', 'home')->middleware('auth');
Route::group(['middleware' => 'auth'], function(){
    Route::resource('user', UserController::class);
    Route::resource('book', BookController::class, ['except', ['index', 'show']]);
});
Route::resource('book', BookController::class, ['only', ['index', 'show']]);







Route::put('user/profile-information', [ProfileInformationController::class, 'update'])
    ->middleware('auth')
    ->name('user-profile-information.update');
Route::put('user/password', [PasswordController::class, 'update'])
    ->middleware('auth')
    ->name('user-password.update');


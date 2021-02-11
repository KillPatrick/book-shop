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

Route::get('/', function () {
    return view('welcome');
});

Route::view('home', 'home')->middleware('auth');
Route::resource('user', UserController::class)->middleware('auth');
Route::resource('book', BookController::class)->middleware('auth');



Route::put('user/profile-information', [ProfileInformationController::class, 'update'])
    ->middleware('auth')
    ->name('user-profile-information.update');
Route::put('user/password', [PasswordController::class, 'update'])
    ->middleware('auth')
    ->name('user-password.update');


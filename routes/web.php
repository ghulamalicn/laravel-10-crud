<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/ls', function () {
    return view('login-signup');
})->name('ls');
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::resource('users', UserController::class);

});
Route::get('/profile', function () {
    return view('profile');
})->name('profile');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::put('/profile-update/{id}/', [App\Http\Controllers\UserController::class, 'profileUpdate'])->name('profile-update');

Auth::routes();

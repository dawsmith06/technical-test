<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('states/{country_id}', function ($country_id) {
    return App\Models\State::where("country_id",$country_id)->get();
});

Route::get('cities/{state_id}', function ($state_id) {
    return App\Models\City::where("state_id",$state_id)->get();
});

Route::middleware(['auth'])->group(function () {
    Route::get('users', [App\Http\Controllers\UsersController::class,'index']);
    Route::put('users', [App\Http\Controllers\UsersController::class,'update']);
    Route::delete('users/{id}', [App\Http\Controllers\UsersController::class,'destroy']);
    Route::get('users-list', [App\Http\Controllers\UsersController::class,'list']);

    Route::resource('emails', App\Http\Controllers\EmailsController::class)->only([
        'index', 'store'
    ]);
    Route::get('emails-list', [App\Http\Controllers\EmailsController::class,'list']);
});
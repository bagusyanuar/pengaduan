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
Route::match(['post', 'get'], '/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->middleware('auth:web');
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('/pengaduan', [\App\Http\Controllers\HomeController::class, 'complain_page']);

//admin page
Route::group(['prefix' => 'admin', 'middleware' => 'auth:web'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\Dashboard::class, 'index']);

    Route::group(['prefix' => 'complain'], function (){
        Route::get('/dashboard', [\App\Http\Controllers\Admin\Dashboard::class, 'complain_data']);
    });
});

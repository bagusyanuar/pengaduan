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
    Route::get('/', [\App\Http\Controllers\Admin\Dashboard::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'users'], function () {

        Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('users.index');
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\AdminController::class, 'add'])->name('users.add');
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'patch'])->name('users.patch');
        Route::match(['post', 'get'], '/{id}/password', [\App\Http\Controllers\Admin\AdminController::class, 'change_password']);
        Route::post( '/{id}/delete', [\App\Http\Controllers\Admin\AdminController::class, 'destroy'])->name('users.destroy');

        Route::group(['prefix' => 'uki'], function () {

        });
    });

    Route::group(['prefix' => 'satker'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\SatuanKerjaController::class, 'index'])->name('unit.index');
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\SatuanKerjaController::class, 'add'])->name('unit.add');
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\SatuanKerjaController::class, 'patch'])->name('unit.patch');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\SatuanKerjaController::class, 'destroy'])->name('unit.destroy');
    });

    Route::group(['prefix' => 'ppk'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\PPKController::class, 'index'])->name('ppk.index');
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\PPKController::class, 'add'])->name('ppk.add');
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\PPKController::class, 'patch'])->name('ppk.patch');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\PPKController::class, 'destroy'])->name('ppk.destroy');
    });
    Route::group(['prefix' => 'complain'], function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\Dashboard::class, 'complain_data']);
    });


});

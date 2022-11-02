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
Route::match(['post', 'get'], '/pengaduan', [\App\Http\Controllers\ComplainController::class, 'index']);

//admin page
Route::group(['prefix' => 'admin', 'middleware' => 'auth:web'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\Dashboard::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'users'], function () {

        Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('users.index');
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\AdminController::class, 'add'])->name('users.add');
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'patch'])->name('users.patch');
//        Route::match(['post', 'get'], '/{id}/password', [\App\Http\Controllers\Admin\AdminController::class, 'change_password']);
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\AdminController::class, 'destroy'])->name('users.destroy');

        Route::group(['prefix' => 'uki'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\UserUkiController::class, 'index'])->name('users.uki.index');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\UserUkiController::class, 'add'])->name('users.uki.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\UserUkiController::class, 'patch'])->name('users.uki.patch');
//            Route::match(['post', 'get'], '/{id}/password', [\App\Http\Controllers\Admin\UserUkiController::class, 'change_password']);
            Route::post('/{id}/delete', [\App\Http\Controllers\Admin\UserUkiController::class, 'destroy'])->name('users.uki.destroy');
        });

        Route::group(['prefix' => 'satuan-kerja'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\UserSatuanKerjaController::class, 'index'])->name('users.satker.index');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\UserSatuanKerjaController::class, 'add'])->name('users.satker.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\UserSatuanKerjaController::class, 'patch'])->name('users.satker.patch');
//            Route::match(['post', 'get'], '/{id}/password', [\App\Http\Controllers\Admin\UserUkiController::class, 'change_password']);
            Route::post('/{id}/delete', [\App\Http\Controllers\Admin\UserSatuanKerjaController::class, 'destroy'])->name('users.satker.destroy');
        });

        Route::group(['prefix' => 'ppk'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\UserPPKController::class, 'index'])->name('users.ppk.index');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\UserPPKController::class, 'add'])->name('users.ppk.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\UserPPKController::class, 'patch'])->name('users.ppk.patch');
//            Route::match(['post', 'get'], '/{id}/password', [\App\Http\Controllers\Admin\UserUkiController::class, 'change_password']);
            Route::post('/{id}/delete', [\App\Http\Controllers\Admin\UserPPKController::class, 'destroy'])->name('users.ppk.destroy');
        });
    });

    Route::group(['prefix' => 'pengaduan'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\ComplainController::class, 'index'])->name('complain.index');
        Route::get('/data', [\App\Http\Controllers\Admin\ComplainController::class, 'complain_data'])->name('complain.data');
        Route::post('/{id}/process', [\App\Http\Controllers\Admin\ComplainController::class, 'send_process'])->name('complain.process');
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

Route::group(['prefix' => 'admin-uki', 'middleware' => 'auth:web'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\Dashboard::class, 'index_uki'])->name('dashboard.uki');

    Route::group(['prefix' => 'pengaduan'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\ComplainController::class, 'index_uki'])->name('complain.index.uki');
        Route::get('/data', [\App\Http\Controllers\Admin\ComplainController::class, 'complain_data_uki'])->name('complain.data.uki');
//        Route::post('/{id}/process', [\App\Http\Controllers\Admin\ComplainController::class, 'send_process'])->name('complain.process');
        Route::get('/{ticket}/info', [\App\Http\Controllers\Admin\ComplainController::class, 'data_detail_by_ticket'])->name('complain.data.by.ticket');
        Route::post('/{id}/disposition', [\App\Http\Controllers\Admin\ComplainController::class, 'send_disposition'])->name('complain.data.send.disposition');
    });
});

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
Route::match(['post', 'get'], '/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->middleware('auth:web');
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::match(['post', 'get'], '/pengaduan', [\App\Http\Controllers\ComplainController::class, 'index']);
Route::get('/pengaduan/berhasil', [\App\Http\Controllers\ComplainController::class, 'success'])->name('complain.success');
Route::match(['post', 'get'], '/informasi', [\App\Http\Controllers\InformationController::class, 'index']);
Route::get('/informasi/berhasil', [\App\Http\Controllers\InformationController::class, 'success'])->name('information.success');
Route::group(['prefix' => 'lacak-laporan'], function () {
    Route::get('/', [\App\Http\Controllers\TracingController::class, 'index'])->name('tracing.index');
    Route::get('/{ticket}', [\App\Http\Controllers\TracingController::class, 'tracing_result'])->name('tracing.result');
});

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
            Route::post('/{id}/delete', [\App\Http\Controllers\Admin\UserSatuanKerjaController::class, 'destroy'])->name('users.satker.destroy');
        });

        Route::group(['prefix' => 'ppk'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\UserPPKController::class, 'index'])->name('users.ppk.index');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\UserPPKController::class, 'add'])->name('users.ppk.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\UserPPKController::class, 'patch'])->name('users.ppk.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\Admin\UserPPKController::class, 'destroy'])->name('users.ppk.destroy');
        });
    });

    Route::group(['prefix' => 'pengaduan'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\ComplainController::class, 'index'])->name('complain.index');
        Route::get('/data', [\App\Http\Controllers\Admin\ComplainController::class, 'complain_data'])->name('complain.data');
        Route::get('/proses', [\App\Http\Controllers\Admin\ComplainController::class, 'on_process'])->name('complain.process');
        Route::get('/jawab', [\App\Http\Controllers\Admin\ComplainController::class, 'answered'])->name('complain.answered');
        Route::get('/selesai', [\App\Http\Controllers\Admin\ComplainController::class, 'finished'])->name('complain.finished');
        Route::post('/{id}/process', [\App\Http\Controllers\Admin\ComplainController::class, 'send_process'])->name('complain.process.send');
        Route::post('/{id}/reply', [\App\Http\Controllers\Admin\ComplainController::class, 'reply_complain'])->name('complain.process.reply');
    });

    Route::group(['prefix' => 'informasi'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\InformationController::class, 'index'])->name('information.index');
        Route::get('/data', [\App\Http\Controllers\Admin\InformationController::class, 'information_data'])->name('information.data');
        Route::get('/proses', [\App\Http\Controllers\Admin\InformationController::class, 'on_process'])->name('information.process');
        Route::get('/jawab', [\App\Http\Controllers\Admin\InformationController::class, 'answered'])->name('information.answered');
        Route::get('/selesai', [\App\Http\Controllers\Admin\InformationController::class, 'finished'])->name('information.finished');
        Route::post('/{id}/process', [\App\Http\Controllers\Admin\InformationController::class, 'send_process'])->name('information.process.send');
        Route::post('/{id}/reply', [\App\Http\Controllers\Admin\InformationController::class, 'reply_information'])->name('information.process.reply');
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


//uki part
Route::group(['prefix' => 'admin-uki', 'middleware' => ['auth', 'uki']], function () {
    Route::get('/', [\App\Http\Controllers\Admin\Dashboard::class, 'index_uki'])->name('dashboard.uki');

    Route::group(['prefix' => 'pengaduan'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\ComplainController::class, 'index_uki'])->name('complain.index.uki');
        Route::get('/proses', [\App\Http\Controllers\Admin\ComplainController::class, 'on_process_uki'])->name('complain.process.uki');
        Route::get('/data', [\App\Http\Controllers\Admin\ComplainController::class, 'complain_data_uki'])->name('complain.data.uki');
        Route::match(['post', 'get'], '/{ticket}/info', [\App\Http\Controllers\Admin\ComplainController::class, 'data_detail_by_ticket'])->name('complain.data.uki.by.ticket');
        Route::match(['post', 'get'], '/{ticket}/jawaban', [\App\Http\Controllers\Admin\ComplainController::class, 'complain_answers_by_ticket'])->name('complain.answers.uki.by.ticket');
        Route::get('/{ticket}/jawaban/data', [\App\Http\Controllers\Admin\ComplainController::class, 'complain_answers_by_ticket_data'])->name('complain.answers.uki.by.ticket.data');
    });

    Route::group(['prefix' => 'informasi'], function (){
        Route::get('/', [\App\Http\Controllers\Admin\InformationController::class, 'index_uki'])->name('information.index.uki');
        Route::get('/proses', [\App\Http\Controllers\Admin\InformationController::class, 'on_process_uki'])->name('information.process.uki');
        Route::get('/data', [\App\Http\Controllers\Admin\InformationController::class, 'information_data_uki'])->name('information.data.uki');
        Route::match(['post', 'get'], '/{ticket}/info', [\App\Http\Controllers\Admin\InformationController::class, 'data_detail_by_ticket'])->name('information.data.uki.by.ticket');
        Route::match(['post', 'get'], '/{ticket}/jawaban', [\App\Http\Controllers\Admin\InformationController::class, 'information_answers_by_ticket'])->name('information.answers.uki.by.ticket');
        Route::get('/{ticket}/jawaban/data', [\App\Http\Controllers\Admin\InformationController::class, 'information_answers_by_ticket_data'])->name('information.answers.uki.by.ticket.data');

    });
});

//satker route part
Route::group(['prefix' => 'admin-satker', 'middleware' => ['auth', 'satker']], function () {
    Route::get('/', [\App\Http\Controllers\Admin\Dashboard::class, 'index_satker'])->name('dashboard.satker');

    Route::group(['prefix' => 'pengaduan'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\ComplainController::class, 'index_satker'])->name('complain.index.satker');
        Route::get('/data', [\App\Http\Controllers\Admin\ComplainController::class, 'complain_data_satker'])->name('complain.data.satker');
        Route::match(['post', 'get'], '/{ticket}/info', [\App\Http\Controllers\Admin\ComplainController::class, 'data_detail_by_ticket_satker'])->name('complain.data.satker.by.ticket');
        Route::get('/{ticket}/jawaban/riwayat', [\App\Http\Controllers\Admin\ComplainController::class, 'complain_answers_data'])->name('complain.answers.satker.data.by.ticket');
    });

    Route::group(['prefix' => 'informasi'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\InformationController::class, 'index_satker'])->name('information.index.satker');
        Route::get('/data', [\App\Http\Controllers\Admin\InformationController::class, 'information_data_satker'])->name('information.data.satker');
        Route::match(['post', 'get'], '/{ticket}/info', [\App\Http\Controllers\Admin\InformationController::class, 'data_detail_by_ticket_satker'])->name('information.data.satker.by.ticket');
        Route::get('/{ticket}/jawaban/riwayat', [\App\Http\Controllers\Admin\InformationController::class, 'information_answers_data'])->name('information.answers.satker.data.by.ticket');
    });
});

//ppk route part
Route::group(['prefix' => 'admin-ppk', 'middleware' => ['auth', 'ppk']], function () {
    Route::get('/', [\App\Http\Controllers\Admin\Dashboard::class, 'index_ppk'])->name('dashboard.ppk');

    Route::group(['prefix' => 'pengaduan'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\ComplainController::class, 'index_ppk'])->name('complain.index.ppk');
        Route::get('/data', [\App\Http\Controllers\Admin\ComplainController::class, 'complain_data_ppk'])->name('complain.data.ppk');
        Route::match(['post', 'get'], '/{ticket}/info', [\App\Http\Controllers\Admin\ComplainController::class, 'data_detail_by_ticket_ppk'])->name('complain.data.ppk.by.ticket');
        Route::get('/{ticket}/jawaban/riwayat', [\App\Http\Controllers\Admin\ComplainController::class, 'complain_answers_data'])->name('complain.answers.ppk.data.by.ticket');
    });

    Route::group(['prefix' => 'informasi'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\InformationController::class, 'index_ppk'])->name('information.index.ppk');
        Route::get('/data', [\App\Http\Controllers\Admin\InformationController::class, 'information_data_ppk'])->name('information.data.ppk');
        Route::match(['post', 'get'], '/{ticket}/info', [\App\Http\Controllers\Admin\InformationController::class, 'data_detail_by_ticket_ppk'])->name('information.data.ppk.by.ticket');
        Route::get('/{ticket}/jawaban/riwayat', [\App\Http\Controllers\Admin\InformationController::class, 'information_answers_data'])->name('information.answers.ppk.data.by.ticket');
    });
});

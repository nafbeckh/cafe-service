<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    DashboardController,
    KategoriController,
    MenuController,
    MejaController,
    UserController,
    PesananController,
    PemesananController,
    SettingController
};

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

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');;

    Route::group(['middleware' => ['role:admin']], function () {
        Route::post('kategori/destroyBatch', [KategoriController::class, 'destroyBatch'])->name('kategori.destroy.batch');
        Route::resource('kategori', KategoriController::class)->except('create', 'show');

        Route::post('menu/destroyBatch', [MenuController::class, 'destroyBatch'])->name('menu.destroy.batch');
        Route::resource('menu', MenuController::class)->except('create', 'show');

        Route::resource('meja', MejaController::class)->only('store', 'index');
        Route::post('meja/destroyBatch', [MejaController::class, 'destroyBatch'])->name('meja.destroy.batch');
        Route::resource('meja', MejaController::class)->except('create', 'show');

        Route::post('user/destroyBatch', [UserController::class, 'destroyBatch'])->name('user.destroy.batch');
        Route::resource('user', UserController::class)->except('create', 'show');
        
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.cafe');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.cafe.update');
    });

    Route::group(['middleware' => ['role:chef']], function () {
        Route::get('pesanan', [PesananController::class, 'index'])->name('pesanan.index');
        Route::post('pesanan/konfirmasi', [PesananController::class, 'konfirmasiPesanan'])->name('pesanan.konfirmasi');
        Route::post('pesanan/siap', [PesananController::class, 'pesananSiap'])->name('pesanan.siap');
    });

    Route::group(['middleware' => ['role:waiter']], function () {
        Route::get('pesanan/meja', [PesananController::class, 'meja'])->name('pesanan.meja');
        Route::get('pesanan/menu/{id}', [PesananController::class, 'menu'])->name('pesanan.menu');
        Route::get('pesanan/getmenu', [PesananController::class, 'getMenu'])->name('pesanan.getmenu');
        Route::post('pesanan/pesan', [PesananController::class, 'pesan'])->name('pesanan.pesan');
        Route::get('pesanan/detail/{no_pesanan}', [PesananController::class, 'showDetail'])->name('pesanan.detail');
        Route::get('pesanan/print/{no_pesanan}', [PesananController::class, 'print'])->name('pesanan.print');
        Route::post('pesanan/selesai', [PesananController::class, 'pesananSelesai'])->name('pesanan.selesai');
    
    });

    Route::group(['middleware' => ['role:chef|waiter']], function () {
        Route::get('pesanan/detail/{no_pesanan}', [PesananController::class, 'showDetail'])->name('pesanan.detail');
    });

    Route::get('/profile', [SettingController::class, 'profile'])->name('setting.profile');
    Route::post('/profile', [SettingController::class, 'profileUpdate'])->name('setting.profileUpdate');

});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    DashboardController,
    KategoriController,
    MenuController,
    MejaController,
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

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');;
       
        Route::post('kategori/destroyBatch', [KategoriController::class, 'destroyBatch'])->name('kategori.destroy.batch');
        Route::resource('kategori', KategoriController::class)->except('create', 'show');

        Route::post('menu/destroyBatch', [MenuController::class, 'destroyBatch'])->name('menu.destroy.batch');
        Route::resource('menu', MenuController::class)->except('create', 'show');

        Route::resource('meja', MejaController::class)->only('store', 'index');
        Route::post('meja/destroyBatch', [MejaController::class, 'destroyBatch'])->name('meja.destroy.batch');
        Route::resource('meja', MejaController::class)->except('create', 'show');
        
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.cafe');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.cafe.update');
    });

    Route::get('/profile', [SettingController::class, 'profile'])->name('setting.profile');
    Route::post('/profile', [SettingController::class, 'profileUpdate'])->name('setting.profileUpdate');

});

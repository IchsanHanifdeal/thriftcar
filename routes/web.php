<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CicilanController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;

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

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login', [LoginController::class, 'auth'])->name('auth');
Route::get('/register', [LoginController::class, 'show_register'])->name('show.register');
Route::get('/register', [LoginController::class, 'show_register'])->name('show.register');
Route::post('/register/store', [LoginController::class, 'store'])->name('store.register');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/customer', [CustomerController::class, 'index'])->name('customer');
    Route::delete('/dashboard/customer/{id_customer}', [CustomerController::class, 'destroy'])->name('hapus_customer');

    Route::get('/dashboard/mobil', [MobilController::class, 'index'])->name('mobil');
    Route::post('/dashboard/mobil/tambah', [MobilController::class, 'store'])->name('tambah_mobil');
    Route::delete('/dashboard/mobil/delete/{id_mobil}', [MobilController::class, 'destroy'])->name('hapus_mobil');
    Route::put('/dashboard/mobil/update/{id_mobil}', [MobilController::class, 'update'])->name('update_mobil');

    Route::get('/dashboard/penjualan', [PenjualanController::class, 'index'])->name('penjualan');
    Route::delete('/dashboard/penjualan/{id_penjualan}', [PenjualanController::class, 'destroy'])->name('hapus_penjualan');

    Route::get('/dashboard/cicilan', [CicilanController::class, 'index'])->name('cicilan');
    Route::put('/dashboard/cicilan/{id_cicilan}', [CicilanController::class, 'cicil'])->name('bayar_cicilan');
    Route::put('/dashboard/cicilan/tolak/{id_cicilan}', [CicilanController::class, 'tolak'])->name('tolak_cicilan');
    Route::put('/dashboard/cicilan/terima/{id_cicilan}', [CicilanController::class, 'terima'])->name('terima_cicilan');

    Route::get('/dashboard/gallery', [GalleryController::class, 'index'])->name('galery');

    Route::get('/dashboard/payment/cash/{id_mobil}', [PenjualanController::class, 'payment'])->name('cash');
    Route::post('/dashboard/payment/cash/payment/{id_mobil}', [PenjualanController::class, 'store_payment'])->name('payment_cash');

    Route::get('/dashboard/payment/kredit/{id_mobil}', [PenjualanController::class, 'payment_kredit'])->name('kredit');
    Route::post('/dashboard/payment/kredit/payment/{id_mobil}', [PenjualanController::class, 'store_payment_kredit'])->name('payment_kredit');

    Route::get('/dashboard/ubahprofil', [ProfilController::class, 'index'])->name('profil');

    Route::get('/dashboard/ubahpassword', [ProfilController::class, 'password'])->name('ubahpassword');
    Route::put('/dashboard/ubahpassword/ubah', [ProfilController::class, 'updatePassword'])->name('ubah_password');
});

// Route::get('/dashboard/ubahprofil', [GalleryController::class, 'index'])->name('galery');
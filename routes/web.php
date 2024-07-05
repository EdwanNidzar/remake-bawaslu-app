<?php

use App\Http\Controllers\LaporanPelanggaranController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\JenisPelanggaranController;
use App\Http\Controllers\ParpolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('parpols', ParpolController::class)->middleware(['auth', 'verified']);

Route::resource('jenispelanggarans', JenisPelanggaranController::class)->middleware(['auth', 'verified']);

Route::resource('pelanggarans', PelanggaranController::class)->middleware(['auth', 'verified']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('laporanpelanggarans', LaporanPelanggaranController::class);
    Route::get('laporanpelanggarans/regency/{province_id}', [LaporanPelanggaranController::class, 'getRegency']);
    Route::get('laporanpelanggarans/districts/{regency_id}', [LaporanPelanggaranController::class, 'getDistricts']);
    Route::get('laporanpelanggarans/villages/{district_id}', [LaporanPelanggaranController::class, 'getVillages']);
    Route::post('laporanpelanggarans/{laporanpelanggaran}/verif', [LaporanPelanggaranController::class, 'verify'])->name('laporanpelanggarans.verif');
    Route::post('laporanpelanggarans/{laporanpelanggaran}/reject', [LaporanPelanggaranController::class, 'reject'])->name('laporanpelanggarans.reject');
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\karyawan\karyawanController;

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



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');


// Data Karyawan

Route::prefix('/karyawan')->name('karyawan.')->group(function () {
        
    Route::get('/', [karyawanController::class, 'index'])->name('index');
    Route::post('/store', [karyawanController::class, 'store'])->name('store');
    Route::put('/update/{id}', [karyawanController::class, 'update'])->name('update'); 
    Route::delete('/destroy/{id}', [karyawanController::class, 'destroy']) ->name('destroy');

});
    Route::get('karyawanshow{id}', [karyawanController::class, 'show'])->name('show');
    Route::get('karyawanedit{id}', [karyawanController::class, 'edit'])->name('edit');
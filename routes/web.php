<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);      // menampilkan data user dalam bentuk json datables
    Route::get('/create', [UserController::class, 'create']);  // menampilkan halaman form tambah user 
    Route::post('/', [UserController::class, 'store']);         // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // m
    Route::post('/ajax', [UserController::class, 'store_ajax']); // m
    Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);     // menyimpan perubahan data user
    Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);       // menampilkan detail user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);
    Route::post('/list', [LevelController::class, 'list']);
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
    Route::post('/store_ajax', [LevelController::class, 'store_ajax']); 
    Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    Route::delete('/{id}', [LevelController::class, 'destroy']);
});


Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);
    Route::post('/list', [KategoriController::class, 'list']);
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
    Route::post('/store_ajax', [KategoriController::class, 'store_ajax']); 
    Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
    Route::post('/store_ajax', [BarangController::class, 'store_ajax']);
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']);
    Route::post('/list', [StokController::class, 'list']);
    Route::get('/create', [StokController::class, 'create']);
    Route::post('/', [StokController::class, 'store']);
    Route::get('/create_ajax', [StokController::class, 'create_ajax']);
    Route::post('/ajax', [StokController::class, 'store_ajax']);
    Route::get('/get_current_stock', [StokController::class, 'get_current_stock']);
    Route::get('/{id}', [StokController::class, 'show']);
    Route::get('/{id}/edit', [StokController::class, 'edit']);
    Route::put('/{id}', [StokController::class, 'update']);
    Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);
    Route::delete('/{id}', [StokController::class, 'destroy']);
});

Route::group(['prefix' => 'transaksi'], function () {
    Route::get('/', [TransactionController::class, 'index']);
    Route::post('/list', [TransactionController::class, 'list']);
    Route::get('/create', [TransactionController::class, 'create']);
    Route::post('/', [TransactionController::class, 'store']);
    Route::get('/create_ajax', [TransactionController::class, 'create_ajax']);
    Route::post('/ajax', [TransactionController::class, 'store_ajax']);
    Route::get('/get_current_stock', [TransactionController::class, 'get_current_stock']);
    Route::get('/{id}', [TransactionController::class, 'show']);
    Route::get('/{id}/edit', [TransactionController::class, 'edit']);
    Route::put('/{id}', [TransactionController::class, 'update']);
    Route::get('/{id}/edit_ajax', [TransactionController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [TransactionController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [TransactionController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [TransactionController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [TransactionController::class, 'show_ajax']);
    Route::delete('/{id}', [TransactionController::class, 'destroy']);
});
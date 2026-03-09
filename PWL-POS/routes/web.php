<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/level', [LevelController::class, 'index']);

Route::get('/kategori', [KategoriController::class, 'index']);

// CRUD Routes untuk User Management
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::post('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

Route::get('/category/{category}', [ProductController::class, 'category']);

Route::get('/user/{id}/name/{name}', [UserController::class, 'profile']);

Route::get('/sales', [SalesController::class, 'index']);

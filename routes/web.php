<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\KategoriController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\SubKategoriController;
use App\Http\Controllers\admin\BukuController;
use App\Http\Controllers\admin\PeminjamanController;
use App\Http\Controllers\admin\StockController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\user\UserPeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes (protected)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management routes
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    
    // Kategori routes
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    
    // SubKategori routes
    Route::get('/subkategori', [SubKategoriController::class, 'index'])->name('subkategori.index');
    Route::get('/subkategori/create', [SubKategoriController::class, 'create'])->name('subkategori.create');
    Route::post('/subkategori', [SubKategoriController::class, 'store'])->name('subkategori.store');
    Route::get('/subkategori/{subkategori}/edit', [SubKategoriController::class, 'edit'])->name('subkategori.edit');
    Route::put('/subkategori/{subkategori}', [SubKategoriController::class, 'update'])->name('subkategori.update');
    Route::delete('/subkategori/{subkategori}', [SubKategoriController::class, 'destroy'])->name('subkategori.destroy');
    
    // Buku routes
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
    
    // Stock routes
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
    Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
    Route::get('/stock/{stock}/edit', [StockController::class, 'edit'])->name('stock.edit');
    Route::put('/stock/{stock}', [StockController::class, 'update'])->name('stock.update');
    Route::delete('/stock/{stock}', [StockController::class, 'destroy'])->name('stock.destroy');
    
    // Peminjaman routes - hanya aksi admin
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/peminjaman/{peminjaman}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/peminjaman/{peminjaman}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('/peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

    // Aksi admin untuk peminjaman
    Route::patch('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::patch('/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::patch('/peminjaman/{peminjaman}/return', [PeminjamanController::class, 'return'])->name('peminjaman.return');


});

// User routes
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/buku', [UserController::class, 'bukuIndex'])->name('buku.index');
    Route::get('/buku/{buku}', [UserController::class, 'bukuShow'])->name('buku.show');
    
    // Peminjaman routes untuk user
    Route::get('/peminjaman', [UserPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create/{stock?}', [UserPeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [UserPeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{peminjaman}', [UserPeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::patch('/peminjaman/{peminjaman}/cancel', [UserPeminjamanController::class, 'cancel'])->name('peminjaman.cancel');
    
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
});

// Admin routes - gunakan AdminUserController untuk manage users
Route::resource('user', AdminUserController::class);











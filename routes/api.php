<?php

use App\Http\Controllers\api\AuthApiController;
use App\Http\Controllers\api\SubKategoriApiController;
use App\Http\Controllers\api\BukuApiController;
use App\Http\Controllers\api\KategoriApiController as ApiKategoriApiController;
use App\Http\Controllers\api\StockApiController;
use App\Http\Controllers\api\PeminjamanApiController;
use App\Http\Controllers\api\KategoriApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public API routes
Route::post('/login', [AuthApiController::class, 'login']);

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/profile', [AuthApiController::class, 'profile']);
    
    
    // Peminjaman API
    Route::get('/peminjamans', [PeminjamanApiController::class, 'index']);
    Route::post('/peminjamans', [PeminjamanApiController::class, 'store']);
    Route::get('/peminjamans/{peminjaman}', [PeminjamanApiController::class, 'show']);
    Route::patch('/peminjamans/{peminjaman}/cancel', [PeminjamanApiController::class, 'cancel']);
});
// Master Data API
Route::get('/kategoris', [KategoriApiController::class, 'index']);
Route::get('/subkategoris', [SubKategoriApiController::class, 'index']);
Route::get('/bukus', [BukuApiController::class, 'index']);
Route::get('/stocks', [StockApiController::class, 'index']);

// Frontend API - All data endpoint
Route::get('/fe', function () {
    $kategoris = app(KategoriApiController::class)->index()->getData();
    $subkategoris = app(SubKategoriApiController::class)->index()->getData();
    $bukus = app(BukuApiController::class)->index()->getData();
    $stocks = app(StockApiController::class)->index()->getData();
    
    return response()->json([
        'success' => true,
        'message' => 'Semua data berhasil diambil',
        'data' => [
            'kategoris' => $kategoris->data,
            'subkategoris' => $subkategoris->data,
            'bukus' => $bukus->data,
            'stocks' => $stocks->data
        ]
    ]);
});

Route::prefix('fe')->group(function () {
    Route::get('kategori', [KategoriApiController::class, 'index']);
    Route::get('subkategori', [SubKategoriApiController::class, 'index']);
    Route::get('buku', [BukuApiController::class, 'index']);
    Route::get('stock', [StockApiController::class, 'index']);
});








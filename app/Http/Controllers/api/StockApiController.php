<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockApiController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('buku.subKategoris.kategoris')->latest()->get();
        
        $formattedStocks = $stocks->map(function ($stock) {
            return [
                'id' => $stock->id,
                'stock' => $stock->stock,
                'status' => $stock->status,
                'created_at' => $stock->created_at,
                'updated_at' => $stock->updated_at,
                'buku' => [
                    'id' => $stock->buku->id,
                    'foto' => $stock->buku->foto ? url('storage/' . $stock->buku->foto) : null,
                    'kode_buku' => $stock->buku->kode_buku,
                    'judul_buku' => $stock->buku->judul_buku,
                    'penerbit' => $stock->buku->penerbit,
                    'pengarang' => $stock->buku->pengarang,
                    'tahun_terbit' => $stock->buku->tahun_terbit,
                    'halaman' => $stock->buku->halaman,
                    'sinopsis' => $stock->buku->sinopsis,
                    'sub_kategori' => [
                        'id' => $stock->buku->subKategoris->id ?? null,
                        'nama_sub_kategori' => $stock->buku->subKategoris->nama_sub_kategori ?? null,
                        'kategori' => [
                            'id' => $stock->buku->subKategoris->kategoris->id ?? null,
                            'nama_kategori' => $stock->buku->subKategoris->kategoris->nama_kategori ?? null,
                        ]
                    ]
                ]
            ];
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Data stock berhasil diambil',
            'data' => $formattedStocks
        ]);
    }
}

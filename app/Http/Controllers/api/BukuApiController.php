<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuApiController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('subKategoris.kategoris')->latest()->get();

        // Transform data untuk API response
        $formattedBukus = $bukus->map(function ($buku) {
            return [
                'id' => $buku->id,
                'foto' => url('storage/' . $buku->foto),
                'kode_buku' => $buku->kode_buku,
                'judul_buku' => $buku->judul_buku,
                'penerbit' => $buku->penerbit,
                'pengarang' => $buku->pengarang,
                'id_sub_kategori' => $buku->id_sub_kategori,
                'created_at' => $buku->created_at,
                'updated_at' => $buku->updated_at,
                'sub_kategori' => [
                    'id' => $buku->subKategoris->id ?? null,
                    'nama_sub_kategori' => $buku->subKategoris->nama_sub_kategori ?? null,
                    'kategori' => [
                        'id' => $buku->subKategoris->kategoris->id ?? null,
                        'nama_kategori' => $buku->subKategoris->kategoris->nama_kategori ?? null,
                    ]
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data buku berhasil diambil',
            'data' => $formattedBukus
        ]);
    }
}

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
        
        return response()->json([
            'success' => true,
            'message' => 'Data buku berhasil diambil',
            'data' => $bukus
        ]);
    }
}
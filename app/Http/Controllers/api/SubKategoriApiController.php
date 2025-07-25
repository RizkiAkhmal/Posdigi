<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\SubKategori;
use Illuminate\Http\Request;

class SubKategoriApiController extends Controller
{
    public function index()
    {
        $subkategoris = SubKategori::with('kategoris')->latest()->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data sub kategori berhasil diambil',
            'data' => $subkategoris
        ]);
    }
}
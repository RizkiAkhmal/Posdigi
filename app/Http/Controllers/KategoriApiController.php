<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriApiController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data kategori berhasil diambil',
            'data' => $kategoris
        ]);
    }
}



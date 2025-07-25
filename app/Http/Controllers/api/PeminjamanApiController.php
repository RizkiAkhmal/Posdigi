<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Stock;
use Illuminate\Http\Request;

class PeminjamanApiController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'stock.buku.subKategoris.kategoris'])
            ->where('id_user', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data peminjaman berhasil diambil',
            'data' => $peminjamans
        ]);
    }

    public function store(Request $request)
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Please login first.'
            ], 401);
        }

        $request->validate([
            'id_stock' => 'required|exists:stocks,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'jumlah' => 'required|integer|min:1',
        ]);

        $stock = Stock::find($request->id_stock);

        if ($stock->stock < $request->jumlah) {
            return response()->json([
                'success' => false,
                'message' => 'Stock tidak mencukupi. Stock tersedia: ' . $stock->stock
            ], 400);
        }

        $peminjaman = Peminjaman::create([
            'id_user' => auth()->id(),
            'id_stock' => $request->id_stock,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'jumlah' => $request->jumlah,
            'status' => 'pending'
        ]);

        $peminjaman->load(['user', 'stock.buku']);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil diajukan',
            'data' => $peminjaman
        ], 201);
    }

    public function show(Peminjaman $peminjaman)
    {
        // Pastikan user hanya bisa melihat peminjaman sendiri
        if ($peminjaman->id_user !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $peminjaman->load(['user', 'stock.buku.subKategoris.kategoris']);

        return response()->json([
            'success' => true,
            'message' => 'Detail peminjaman berhasil diambil',
            'data' => $peminjaman
        ]);
    }

    public function cancel(Peminjaman $peminjaman)
    {
        // Pastikan user hanya bisa cancel peminjaman sendiri
        if ($peminjaman->id_user !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        if ($peminjaman->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman tidak dapat dibatalkan'
            ], 400);
        }

        $peminjaman->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil dibatalkan'
        ]);
    }
}

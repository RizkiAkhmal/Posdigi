<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Stock;
use Illuminate\Http\Request;

class UserPeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['stock.buku.subKategoris.kategoris'])
            ->where('id_user', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.peminjaman.index', compact('peminjamans'));
    }

    public function show(Peminjaman $peminjaman)
    {
        // Pastikan user hanya bisa melihat peminjaman sendiri
        if ($peminjaman->id_user !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $peminjaman->load(['stock.buku.subKategoris.kategoris']);

        return view('user.peminjaman.show', compact('peminjaman'));
    }

    public function create($stockId = null)
    {
        $stock = null;
        if ($stockId) {
            $stock = Stock::with('buku')->findOrFail($stockId);
            
            if ($stock->stock <= 0 || $stock->status !== 'tersedia') {
                return redirect()->route('user.buku.index')
                    ->with('error', 'Buku tidak tersedia untuk dipinjam');
            }
        }

        return view('user.peminjaman.create', compact('stock'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_stock' => 'required|exists:stocks,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'jumlah' => 'required|integer|min:1',
        ]);

        $stock = Stock::find($request->id_stock);

        if ($stock->stock < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stock tidak mencukupi. Stock tersedia: ' . $stock->stock])
                ->withInput();
        }

        if ($stock->status !== 'tersedia') {
            return back()->withErrors(['id_stock' => 'Buku tidak tersedia untuk dipinjam'])
                ->withInput();
        }

        // Cek apakah user sudah punya peminjaman pending untuk buku yang sama
        $existingPeminjaman = Peminjaman::where('id_user', auth()->id())
            ->where('id_stock', $request->id_stock)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingPeminjaman) {
            return back()->withErrors(['id_stock' => 'Anda sudah memiliki peminjaman aktif untuk buku ini'])
                ->withInput();
        }

        $peminjaman = Peminjaman::create([
            'id_user' => auth()->id(),
            'id_stock' => $request->id_stock,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'jumlah' => $request->jumlah,
            'status' => 'pending'
        ]);

        return redirect()->route('user.peminjaman.show', $peminjaman)
            ->with('success', 'Peminjaman berhasil diajukan. Menunggu persetujuan admin.');
    }

    public function cancel(Peminjaman $peminjaman)
    {
        // Pastikan user hanya bisa cancel peminjaman sendiri
        if ($peminjaman->id_user !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman tidak dapat dibatalkan');
        }

        $peminjaman->update(['status' => 'rejected']);

        return redirect()->route('user.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dibatalkan');
    }
}
<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'stock.buku'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $users = User::all();
        $stocks = Stock::with('buku')->where('status', 'tersedia')->where('stock', '>', 0)->get();

        return view('admin.peminjaman.create', compact('users', 'stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_stock' => 'required|exists:stocks,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        $stock = Stock::find($request->id_stock);

        if ($stock->stock < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stock tidak mencukupi. Stock tersedia: ' . $stock->stock]);
        }

        // Hanya buat peminjaman, jangan kurangi stock dulu
        Peminjaman::create($request->all());

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'stock.buku']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $users = User::all();
        $stocks = Stock::with('buku')->where('status', 'tersedia')->where('stock', '>', 0)->get();

        return view('admin.peminjaman.edit', compact('peminjaman', 'users', 'stocks'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_stock' => 'required|exists:stocks,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected,returned'
        ]);

        $peminjaman->update($request->all());

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil diperbarui');
    }

    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman tidak dapat disetujui');
        }

        $stock = $peminjaman->stock;

        // Cek apakah stock masih mencukupi
        if ($stock->stock < $peminjaman->jumlah) {
            return back()->with('error', 'Stock tidak mencukupi. Stock tersedia: ' . $stock->stock);
        }

        // Kurangi stock sesuai jumlah saat approve
        $stock->decrement('stock', $peminjaman->jumlah);

        // Update status stock jika habis
        if ($stock->stock <= 0) {
            $stock->update(['status' => 'habis']);
        }

        $peminjaman->update(['status' => 'approved']);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil disetujui dan stock dikurangi');
    }

    public function reject(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman tidak dapat ditolak');
        }

        // Tidak perlu kembalikan stock karena belum dikurangi
        $peminjaman->update(['status' => 'rejected']);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditolak');
    }

    public function return(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'approved') {
            return back()->with('error', 'Peminjaman tidak dapat dikembalikan');
        }

        // Kembalikan stock sesuai jumlah
        $peminjaman->stock->increment('stock', $peminjaman->jumlah);
        $peminjaman->stock->update(['status' => 'tersedia']);

        $peminjaman->update(['status' => 'returned']);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Buku berhasil dikembalikan');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Jika status approved, kembalikan stock
        if ($peminjaman->status === 'approved') {
            $peminjaman->stock->increment('stock', $peminjaman->jumlah);
            $peminjaman->stock->update(['status' => 'tersedia']);
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus');
    }
}

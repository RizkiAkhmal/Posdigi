<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $totalPeminjaman = Peminjaman::where('id_user', auth()->id())->count();
        $pendingPeminjaman = Peminjaman::where('id_user', auth()->id())->where('status', 'pending')->count();
        $approvedPeminjaman = Peminjaman::where('id_user', auth()->id())->where('status', 'approved')->count();
        $totalBuku = Buku::whereHas('stocks', function($query) {
            $query->where('stock', '>', 0)->where('status', 'tersedia');
        })->count();
        
        $recentPeminjaman = Peminjaman::with(['stock.buku'])
            ->where('id_user', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'totalPeminjaman', 
            'pendingPeminjaman', 
            'approvedPeminjaman', 
            'totalBuku',
            'recentPeminjaman'
        ));
    }

    public function bukuIndex(Request $request)
    {
        $query = Buku::with(['subKategoris.kategoris', 'stocks']);
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul_buku', 'like', '%' . $request->search . '%')
                  ->orWhere('pengarang', 'like', '%' . $request->search . '%')
                  ->orWhere('penerbit', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->kategori) {
            $query->whereHas('subKategoris.kategoris', function($q) use ($request) {
                $q->where('id', $request->kategori);
            });
        }
        
        $bukus = $query->paginate(12);
        $kategoris = Kategori::all();
        
        return view('user.buku.index', compact('bukus', 'kategoris'));
    }

    public function bukuShow(Buku $buku)
    {
        $buku->load(['subKategoris.kategoris', 'stocks']);
        
        return view('user.buku.show', compact('buku'));
    }
}
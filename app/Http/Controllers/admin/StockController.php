<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Buku;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('buku.subKategoris.kategoris')->latest()->get();
        return view('admin.stock.index', compact('stocks'));
    }

    public function create()
    {
        $bukus = Buku::with('subKategoris.kategoris')
                    ->whereDoesntHave('stock')
                    ->get();
        return view('admin.stock.create', compact('bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:bukus,id|unique:stocks,id_buku',
            'stock' => 'required|integer|min:0',
        ]);

        $status = $request->stock > 0 ? 'tersedia' : 'habis';

        Stock::create([
            'id_buku' => $request->id_buku,
            'stock' => $request->stock,
            'status' => $status
        ]);

        return redirect()->route('admin.stock.index')
            ->with('success', 'Stock berhasil ditambahkan');
    }

    public function show(Stock $stock)
    {
        $stock->load('buku.subKategoris.kategoris');
        return view('admin.stock.show', compact('stock'));
    }

    public function edit(Stock $stock)
    {
        $stock->load('buku.subKategoris.kategoris');
        return view('admin.stock.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $status = $request->stock > 0 ? 'tersedia' : 'habis';

        $stock->update([
            'stock' => $request->stock,
            'status' => $status
        ]);

        return redirect()->route('admin.stock.index')
            ->with('success', 'Stock berhasil diperbarui');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        
        return redirect()->route('admin.stock.index')
            ->with('success', 'Stock berhasil dihapus');
    }

    // Tambahkan method untuk mengubah status ke rusak
    public function markAsRusak(Stock $stock)
    {
        $stock->update(['status' => 'rusak']);
        
        return redirect()->route('admin.stock.index')
            ->with('success', 'Stock berhasil ditandai sebagai rusak');
    }
}



<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SubKategori;
use App\Models\Kategori;
use Illuminate\Http\Request;

class SubKategoriController extends Controller
{
    public function index()
    {
        $subkategoris = SubKategori::with('kategoris')->latest()->get();
        return view('admin.subkategori.index', compact('subkategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.subkategori.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sub_kategori' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id'
        ]);

        SubKategori::create([
            'nama_sub_kategori' => $request->nama_sub_kategori,
            'id_kategori' => $request->id_kategori
        ]);

        return redirect()->route('admin.subkategori.index')
            ->with('success', 'Sub Kategori berhasil ditambahkan');
    }

    public function show(SubKategori $subkategori)
    {
        return view('admin.subkategori.show', compact('subkategori'));
    }

    public function edit(SubKategori $subkategori)
    {
        $kategoris = Kategori::all();
        return view('admin.subkategori.edit', compact('subkategori', 'kategoris'));
    }

    public function update(Request $request, SubKategori $subkategori)
    {
        $request->validate([
            'nama_sub_kategori' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id'
        ]);

        $subkategori->update([
            'nama_sub_kategori' => $request->nama_sub_kategori,
            'id_kategori' => $request->id_kategori
        ]);

        return redirect()->route('admin.subkategori.index')
            ->with('success', 'Sub Kategori berhasil diperbarui');
    }

    public function destroy(SubKategori $subkategori)
    {
        $subkategori->delete();
        
        return redirect()->route('admin.subkategori.index')
            ->with('success', 'Sub Kategori berhasil dihapus');
    }
}
<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('subKategoris')->latest()->get();
        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        $subkategoris = SubKategori::with('kategoris')->get();
        return view('admin.buku.create', compact('subkategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kode_buku' => 'required|string|max:255|unique:bukus,kode_buku',
            'judul_buku' => 'required|string|max:255',
            'id_sub_kategori' => 'required|exists:sub_kategoris,id'
        ]);

        $fotoPath = $request->file('foto')->store('buku', 'public');

        Buku::create([
            'foto' => $fotoPath,
            'kode_buku' => $request->kode_buku,
            'judul_buku' => $request->judul_buku,
            'id_sub_kategori' => $request->id_sub_kategori
        ]);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function show(Buku $buku)
    {
        $buku->load('subKategoris.kategoris');
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $subkategoris = SubKategori::with('kategoris')->get();
        return view('admin.buku.edit', compact('buku', 'subkategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kode_buku' => 'required|string|max:255|unique:bukus,kode_buku,' . $buku->id,
            'judul_buku' => 'required|string|max:255',
            'id_sub_kategori' => 'required|exists:sub_kategoris,id'
        ]);

        $data = [
            'kode_buku' => $request->kode_buku,
            'judul_buku' => $request->judul_buku,
            'id_sub_kategori' => $request->id_sub_kategori
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($buku->foto) {
                Storage::disk('public')->delete($buku->foto);
            }
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Buku $buku)
    {
        // Hapus foto
        if ($buku->foto) {
            Storage::disk('public')->delete($buku->foto);
        }
        
        $buku->delete();
        
        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus');
    }
}

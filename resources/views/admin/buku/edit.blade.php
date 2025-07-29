@extends('layouts.admin')

@section('title', 'Edit Buku')

@section('content')
<div class="card">
    <h2>Edit Buku</h2>
    
    <form method="POST" action="{{ route('admin.buku.update', $buku) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="foto">Foto Buku:</label>
            @if($buku->foto_url)
                <div style="margin-bottom: 10px;">
                    <img src="{{ $buku->foto_url }}" alt="Foto Buku" style="width: 100px; height: 140px; object-fit: cover;">
                </div>
            @endif
            <input type="file" id="foto" name="foto" accept="image/*">
            <small>Kosongkan jika tidak ingin mengubah foto</small>
            @error('foto')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="kode_buku">Kode Buku:</label>
            <input type="text" id="kode_buku" name="kode_buku" value="{{ old('kode_buku', $buku->kode_buku) }}" required>
            @error('kode_buku')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="judul_buku">Judul Buku:</label>
            <input type="text" id="judul_buku" name="judul_buku" value="{{ old('judul_buku', $buku->judul_buku) }}" required>
            @error('judul_buku')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="penerbit">Penerbit:</label>
            <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}">
            @error('penerbit')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="pengarang">Pengarang:</label>
            <input type="text" id="pengarang" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}">
            @error('pengarang')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tahun_terbit">Tahun Terbit:</label>
            <input type="text" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
            @error('tahun_terbit')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="halaman">Halaman:</label>
            <input type="text" id="halaman" name="halaman" value="{{ old('halaman', $buku->halaman) }}">
            @error('halaman')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="sinopsis">Sinopsis:</label>
            <textarea id="sinopsis" name="sinopsis" rows="4">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
            @error('sinopsis')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_sub_kategori">Sub Kategori:</label>
            <select id="id_sub_kategori" name="id_sub_kategori" required>
                <option value="">Pilih Sub Kategori</option>
                @foreach($subkategoris as $subkategori)
                    <option value="{{ $subkategori->id }}" {{ old('id_sub_kategori', $buku->id_sub_kategori) == $subkategori->id ? 'selected' : '' }}>
                        {{ $subkategori->nama_sub_kategori }} ({{ $subkategori->kategoris->nama_kategori }})
                    </option>
                @endforeach
            </select>
            @error('id_sub_kategori')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection




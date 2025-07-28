@extends('layouts.admin')

@section('title', 'Tambah Buku')

@section('content')
<div class="card">
    <h2>Tambah Buku</h2>
    
    <form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="foto">Foto Buku:</label>
            <input type="file" id="foto" name="foto" accept="image/*" required>
            @error('foto')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="kode_buku">Kode Buku:</label>
            <input type="text" id="kode_buku" name="kode_buku" value="{{ old('kode_buku') }}" required>
            @error('kode_buku')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="judul_buku">Judul Buku:</label>
            <input type="text" id="judul_buku" name="judul_buku" value="{{ old('judul_buku') }}" required>
            @error('judul_buku')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="penerbit">Penerbit:</label>
            <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit') }}">
            @error('penerbit')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="pengarang">Pengarang:</label>
            <input type="text" id="pengarang" name="pengarang" value="{{ old('pengarang') }}">
            @error('pengarang')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="id_sub_kategori">Sub Kategori:</label>
            <select id="id_sub_kategori" name="id_sub_kategori" required>
                <option value="">Pilih Sub Kategori</option>
                @foreach($subkategoris as $subkategori)
                    <option value="{{ $subkategori->id }}" {{ old('id_sub_kategori') == $subkategori->id ? 'selected' : '' }}>
                        {{ $subkategori->nama_sub_kategori }} ({{ $subkategori->kategoris->nama_kategori }})
                    </option>
                @endforeach
            </select>
            @error('id_sub_kategori')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection


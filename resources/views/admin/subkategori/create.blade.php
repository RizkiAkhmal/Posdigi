@extends('layouts.admin')

@section('title', 'Tambah Sub Kategori')

@section('content')
<div class="card">
    <h2>Tambah Sub Kategori</h2>
    
    <form method="POST" action="{{ route('admin.subkategori.store') }}">
        @csrf
        <div class="form-group">
            <label for="nama_sub_kategori">Nama Sub Kategori:</label>
            <input type="text" id="nama_sub_kategori" name="nama_sub_kategori" value="{{ old('nama_sub_kategori') }}">
            @error('nama_sub_kategori')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="id_kategori">Kategori:</label>
            <select id="id_kategori" name="id_kategori">
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
            @error('id_kategori')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.subkategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
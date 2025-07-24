@extends('layouts.admin')

@section('title', 'Tambah Stock')

@section('content')
<div class="card">
    <h2>Tambah Stock</h2>
    
    <form method="POST" action="{{ route('admin.stock.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="id_buku">Buku:</label>
            <select id="id_buku" name="id_buku">
                <option value="">Pilih Buku</option>
                @foreach($bukus as $buku)
                    <option value="{{ $buku->id }}" {{ old('id_buku') == $buku->id ? 'selected' : '' }}>
                        {{ $buku->kode_buku }} - {{ $buku->judul_buku }} ({{ $buku->subKategoris->nama_sub_kategori }})
                    </option>
                @endforeach
            </select>
            @error('id_buku')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="stock">Jumlah Stock:</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock') }}" min="0">
            <small>Status akan otomatis: Tersedia jika > 0, Habis jika = 0</small>
            @error('stock')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.stock.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

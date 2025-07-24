@extends('layouts.admin')

@section('title', 'Edit Stock')

@section('content')
<div class="card">
    <h2>Edit Stock</h2>
    
    <form method="POST" action="{{ route('admin.stock.update', $stock) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Buku:</label>
            <div style="padding: 10px; background: #f5f5f5; border-radius: 4px;">
                <strong>{{ $stock->buku->kode_buku }}</strong> - {{ $stock->buku->judul_buku }}
                <br><small>{{ $stock->buku->subKategoris->nama_sub_kategori }}</small>
            </div>
        </div>
        
        <div class="form-group">
            <label for="stock">Jumlah Stock:</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', $stock->stock) }}" min="0">
            <small>Status akan otomatis: Tersedia jika > 0, Habis jika = 0</small>
            @error('stock')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.stock.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection


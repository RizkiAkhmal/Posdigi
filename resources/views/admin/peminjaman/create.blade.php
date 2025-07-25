@extends('layouts.admin')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="card">
    <h2>Tambah Peminjaman</h2>
    
    <form method="POST" action="{{ route('admin.peminjaman.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="id_user">Peminjam:</label>
            <select id="id_user" name="id_user" required>
                <option value="">Pilih Peminjam</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('id_user')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="id_stock">Buku:</label>
            <select id="id_stock" name="id_stock" required>
                <option value="">Pilih Buku</option>
                @foreach($stocks as $stock)
                    <option value="{{ $stock->id }}" {{ old('id_stock') == $stock->id ? 'selected' : '' }}>
                        {{ $stock->buku->judul_buku }} (Stock: {{ $stock->stock }})
                    </option>
                @endforeach
            </select>
            @error('id_stock')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah:</label>
            <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" required>
            @error('jumlah')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="tanggal_pinjam">Tanggal Pinjam:</label>
            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
            @error('tanggal_pinjam')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="tanggal_kembali">Tanggal Kembali:</label>
            <input type="date" id="tanggal_kembali" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required>
            @error('tanggal_kembali')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

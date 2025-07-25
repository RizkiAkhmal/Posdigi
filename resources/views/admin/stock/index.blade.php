@extends('layouts.admin')

@section('title', 'Daftar Stock')

@section('content')
<div class="card">
    <h2>Daftar Stock</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('admin.stock.create') }}" class="btn btn-primary">Tambah Stock</a>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Sub Kategori</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $index => $stock)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @if($stock->buku->foto)
                        <img src="{{ asset('storage/' . $stock->buku->foto) }}" alt="Foto Buku" style="width: 50px; height: 70px; object-fit: cover;">
                    @else
                        <span>No Image</span>
                    @endif
                </td>
                <td>{{ $stock->buku->kode_buku }}</td>
                <td>{{ $stock->buku->judul_buku }}</td>
                <td>{{ $stock->buku->subKategoris->nama_sub_kategori ?? '-' }}</td>
                <td>{{ $stock->stock }}</td>
                <td>
                    <span class="status {{ $stock->status }}">{{ ucfirst($stock->status) }}</span>
                </td>
                <td>
                    {{-- <a href="{{ route('admin.stock.show', $stock) }}" class="btn btn-info">Detail</a> --}}
                    <a href="{{ route('admin.stock.edit', $stock) }}" class="btn btn-primary">Edit</a>
                    <form style="display:inline" method="POST" action="{{ route('admin.stock.destroy', $stock) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


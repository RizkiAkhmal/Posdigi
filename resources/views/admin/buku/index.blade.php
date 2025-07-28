@extends('layouts.admin')

@section('title', 'Daftar Buku')

@section('content')
<div class="card">
    <h2>Daftar Buku</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('admin.buku.create') }}" class="btn btn-primary">Tambah Buku</a>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Penerbit</th>
                <th>Pengarang</th>
                <th>Sub Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bukus as $index => $buku)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @if($buku->foto)
                        <img src=" {{ url("storage/" . $buku->foto)}}" alt="Foto Buku" style="width: 50px; height: 70px; object-fit: cover;">
                    @else
                        <span>No Image</span>
                    @endif
                </td>
                <td>{{ $buku->kode_buku }}</td>
                <td>{{ $buku->judul_buku }}</td>
                <td>{{ $buku->penerbit ?? '-' }}</td>
                <td>{{ $buku->pengarang ?? '-' }}</td>
                <td>{{ $buku->subKategoris->nama_sub_kategori ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.buku.show', $buku) }}" class="btn btn-info">Detail</a>
                    <a href="{{ route('admin.buku.edit', $buku) }}" class="btn btn-primary">Edit</a>
                    <form style="display:inline" method="POST" action="{{ route('admin.buku.destroy', $buku) }}">
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


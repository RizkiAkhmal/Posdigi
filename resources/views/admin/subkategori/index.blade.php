@extends('layouts.admin')

@section('title', 'Daftar Sub Kategori')

@section('content')
<div class="card">
    <h2>Daftar Sub Kategori</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('admin.subkategori.create') }}" class="btn btn-primary">Tambah Sub Kategori</a>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sub Kategori</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subkategoris as $index => $subkategori)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $subkategori->nama_sub_kategori }}</td>
                <td>{{ $subkategori->kategoris->nama_kategori }}</td>
                <td>
                    <a href="{{ route('admin.subkategori.edit', $subkategori) }}" class="btn btn-primary">Edit</a>
                    <form style="display:inline" method="POST" action="{{ route('admin.subkategori.destroy', $subkategori) }}">
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
@extends('layouts.admin')

@section('title', 'Daftar Kategori')

@section('content')
<div class="card">
    <h2>Daftar Kategori</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategoris as $index => $kategori)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kategori->nama_kategori }}</td>
                <td>
                    <a href="{{ route('admin.kategori.edit', $kategori) }}" class="btn btn-primary">Edit</a>
                    <form style="display:inline" method="POST" action="{{ route('admin.kategori.destroy', $kategori) }}">
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

@extends('layouts.admin')

@section('title', 'Detail Buku')

@section('content')
<div class="card">
    <h2>Detail Buku</h2>
    
    <div class="detail-container">
        <div class="detail-image">
            @if($buku->foto)
                <img src="{{ asset('storage/' . $buku->foto) }}" alt="Foto Buku" style="width: 200px; height: 280px; object-fit: cover;">
            @else
                <div style="width: 200px; height: 280px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                    No Image
                </div>
            @endif
        </div>
        
        <div class="detail-info">
            <table>
                <tr>
                    <td><strong>Kode Buku:</strong></td>
                    <td>{{ $buku->kode_buku }}</td>
                </tr>
                <tr>
                    <td><strong>Judul Buku:</strong></td>
                    <td>{{ $buku->judul_buku }}</td>
                </tr>
                <tr>
                    <td><strong>Sub Kategori:</strong></td>
                    <td>{{ $buku->subKategoris->nama_sub_kategori ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Kategori:</strong></td>
                    <td>{{ $buku->subKategoris->kategoris->nama_kategori ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Ditambahkan:</strong></td>
                    <td>{{ $buku->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Diperbarui:</strong></td>
                    <td>{{ $buku->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="actions">
        <a href="{{ route('admin.buku.edit', $buku) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

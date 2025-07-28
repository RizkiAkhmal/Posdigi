@extends('layouts.admin')

@section('title', 'Detail Buku')

@section('content')
    <div class="card">
        <h2>Detail Buku</h2>

        <div class="detail-container">
            <div class="detail-image">

                @if ($buku->foto)
                    <img src=" {{ url('storage/' . $buku->foto) }}" alt="Foto Buku"
                        style="width: 50px; height: 70px; object-fit: cover;">
                @else
                    <span>No Image</span>
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
                        <td><strong>Penerbit:</strong></td>
                        <td>{{ $buku->penerbit ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Pengarang:</strong></td>
                        <td>{{ $buku->pengarang ?? '-' }}</td>
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

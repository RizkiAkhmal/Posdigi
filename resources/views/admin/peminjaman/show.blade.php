@extends('layouts.admin')

@section('content')
<div class="card">
    <h2>Detail Peminjaman</h2>
    
    <div class="row">
        <div class="col-md-12">
            <div class="detail-info">
                <p><strong>Kode Peminjaman:</strong> {{ $peminjaman->qrcode }}</p>
                <p><strong>Peminjam:</strong> {{ $peminjaman->user->name }}</p>
                <p><strong>Email:</strong> {{ $peminjaman->user->email }}</p>
                <p><strong>Buku:</strong> {{ $peminjaman->stock->buku->judul_buku }}</p>
                <p><strong>Kode Buku:</strong> {{ $peminjaman->stock->buku->kode_buku }}</p>
                <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</p>
                <p><strong>Tanggal Kembali:</strong> {{ $peminjaman->tanggal_kembali->format('d/m/Y') }}</p>
                <p><strong>Status:</strong> 
                    <span class="status {{ $peminjaman->status }}">
                        {{ ucfirst($peminjaman->status) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('admin.peminjaman.edit', $peminjaman) }}" class="btn btn-primary">Edit</a>
    </div>
</div>
@endsection


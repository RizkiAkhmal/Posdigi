@extends('layouts.admin')

@section('title', 'Data Peminjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Data Peminjaman</h2>
        <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary">Tambah Peminjaman</a>
    </div>

    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $peminjaman->user->name }}</td>
                    <td>{{ $peminjaman->stock->buku->judul_buku }}</td>
                    <td>{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td>{{ $peminjaman->tanggal_kembali->format('d/m/Y') }}</td>
                    <td>
                        <span class="status {{ $peminjaman->status }}">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.peminjaman.show', $peminjaman) }}" class="btn btn-info btn-sm">Detail</a>
                        
                        @if($peminjaman->status === 'pending')
                            <form style="display:inline" method="POST" action="{{ route('admin.peminjaman.approve', $peminjaman) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                            </form>
                        @endif

                        @if($peminjaman->status === 'approved')
                            <form style="display:inline" method="POST" action="{{ route('admin.peminjaman.return', $peminjaman) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary btn-sm">Kembalikan</button>
                            </form>
                        @endif

                        <a href="{{ route('admin.peminjaman.edit', $peminjaman) }}" class="btn btn-secondary btn-sm">Edit</a>
                        
                        <form style="display:inline" method="POST" action="{{ route('admin.peminjaman.destroy', $peminjaman) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data peminjaman</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $peminjamans->links() }}
    </div>
</div>
@endsection


@extends('layouts.user')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>📋 Riwayat Peminjaman Saya</h2>
    </div>
    
    <div class="peminjaman-list">
        @forelse($peminjamans as $peminjaman)
        <div class="peminjaman-item">
            <div class="peminjaman-book">
                <div class="book-image">
                    @if($peminjaman->stock->buku->foto)
                        <img src="{{ asset('storage/' . $peminjaman->stock->buku->foto) }}" alt="{{ $peminjaman->stock->buku->judul_buku }}">
                    @else
                        <div class="no-image">📖</div>
                    @endif
                </div>
                <div class="book-info">
                    <h3>{{ $peminjaman->stock->buku->judul_buku }}</h3>
                    <p>👤 {{ $peminjaman->stock->buku->pengarang ?? 'Tidak diketahui' }}</p>
                    <p>🏷️ {{ $peminjaman->stock->buku->subKategoris->nama_sub_kategori ?? 'Tidak ada kategori' }}</p>
                </div>
            </div>
            
            <div class="peminjaman-details">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="label">📅 Tanggal Pinjam:</span>
                        <span class="value">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">📅 Tanggal Kembali:</span>
                        <span class="value">{{ $peminjaman->tanggal_kembali->format('d/m/Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">📦 Jumlah:</span>
                        <span class="value">{{ $peminjaman->jumlah }} buku</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">📊 Status:</span>
                        <span class="status {{ $peminjaman->status }}">
                            @if($peminjaman->status == 'pending')
                                ⏳ Menunggu Persetujuan
                            @elseif($peminjaman->status == 'approved')
                                ✅ Disetujui
                            @elseif($peminjaman->status == 'rejected')
                                ❌ Ditolak
                            @else
                                📚 Dikembalikan
                            @endif
                        </span>
                    </div>
                </div>
                
                <div class="peminjaman-actions">
                    <a href="{{ route('user.peminjaman.show', $peminjaman) }}" class="btn btn-info btn-sm">
                        👁️ Detail
                    </a>
                    
                    @if($peminjaman->status === 'pending')
                        <form method="POST" action="{{ route('user.peminjaman.cancel', $peminjaman) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Yakin ingin membatalkan peminjaman ini?')">
                                ❌ Batalkan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="no-peminjaman">
            <div class="no-peminjaman-icon">📚</div>
            <h3>Belum Ada Peminjaman</h3>
            <p>Anda belum pernah meminjam buku. Mulai jelajahi koleksi kami!</p>
            <a href="{{ route('user.buku.index') }}" class="btn btn-primary">
                🔍 Cari Buku
            </a>
        </div>
        @endforelse
    </div>
    
    @if($peminjamans->hasPages())
        <div class="pagination-wrapper">
            {{ $peminjamans->links() }}
        </div>
    @endif
</div>

<style>
.card-header {
    border-bottom: 2px solid #eee;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
}

.peminjaman-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.peminjaman-item {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
    border-left: 5px solid #667eea;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.peminjaman-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.peminjaman-book {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.book-image {
    width: 60px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.book-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 5px;
}

.no-image {
    font-size: 1.5rem;
    color: #ccc;
}

.book-info h3 {
    margin-bottom: 0.25rem;
    color: #333;
    font-size: 1.1rem;
}

.book-info p {
    margin-bottom: 0.25rem;
    color: #666;
    font-size: 0.9rem;
}

.peminjaman-details {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 1rem;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
    flex: 1;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.label {
    font-size: 0.8rem;
    color: #666;
    font-weight: 500;
}

.value {
    font-weight: 600;
    color: #333;
}

.status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-align: center;
}

.status.pending {
    background: #fff3cd;
    color: #856404;
}

.status.approved {
    background: #d4edda;
    color: #155724;
}

.status.rejected {
    background: #f8d7da;
    color: #721c24;
}

.status.returned {
    background: #d1ecf1;
    color: #0c5460;
}

.peminjaman-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.8rem;
}

.btn-info {
    background: #17a2b8;
}

.btn-info:hover {
    background: #138496;
}

.btn-danger {
    background: #dc3545;
}

.btn-danger:hover {
    background: #c82333;
}

.no-peminjaman {
    text-align: center;
    padding: 3rem;
    color: #666;
}

.no-peminjaman-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.no-peminjaman h3 {
    margin-bottom: 0.5rem;
    color: #333;
}

.no-peminjaman p {
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .peminjaman-book {
        flex-direction: column;
        text-align: center;
    }
    
    .book-image {
        align-self: center;
    }
    
    .peminjaman-details {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .peminjaman-actions {
        justify-content: center;
    }
}
</style>
@endsection
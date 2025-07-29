@extends('layouts.user')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="detail-container">
    <div class="detail-card">
        <div class="detail-header">
            <h2>📋 Detail Peminjaman</h2>
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
        
        <div class="book-section">
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
        
        <div class="detail-info">
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">📅 Tanggal Pinjam:</span>
                    <span class="value">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="label">📅 Tanggal Kembali:</span>
                    <span class="value">{{ $peminjaman->tanggal_kembali->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="label">📦 Jumlah:</span>
                    <span class="value">{{ $peminjaman->jumlah }} buku</span>
                </div>
                <div class="info-item">
                    <span class="label">📅 Tanggal Pengajuan:</span>
                    <span class="value">{{ $peminjaman->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
        
        <div class="actions">
            <a href="{{ route('user.peminjaman.index') }}" class="btn btn-secondary">
                ← Kembali ke Riwayat
            </a>
            
            @if($peminjaman->status === 'pending')
                <form method="POST" action="{{ route('user.peminjaman.cancel', $peminjaman) }}" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Yakin ingin membatalkan peminjaman ini?')">
                        ❌ Batalkan Peminjaman
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<style>
.detail-container {
    max-width: 800px;
    margin: 0 auto;
}

.detail-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #eee;
}

.book-section {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 10px;
}

.book-image {
    width: 80px;
    height: 100px;
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

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.label {
    font-weight: 600;
    color: #666;
    font-size: 0.9rem;
}

.value {
    font-size: 1rem;
    color: #333;
}

.status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
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

.actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-start;
}

@media (max-width: 768px) {
    .detail-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .book-section {
        flex-direction: column;
        text-align: center;
    }
    
    .book-image {
        align-self: center;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .actions {
        flex-direction: column;
    }
}
</style>
@endsection
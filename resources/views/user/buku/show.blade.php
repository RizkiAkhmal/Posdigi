@extends('layouts.user')

@section('title', 'Detail Buku')

@section('content')
<div class="book-detail-container">
    <div class="book-detail-card">
        <div class="book-image-section">
            @if($buku->foto)
                <img src="{{ asset('storage/' . $buku->foto) }}" alt="{{ $buku->judul_buku }}" class="book-cover">
            @else
                <div class="no-image-large">📖</div>
            @endif
        </div>
        
        <div class="book-info-section">
            <div class="book-header">
                <h1>{{ $buku->judul_buku }}</h1>
                <span class="book-code">{{ $buku->kode_buku }}</span>
            </div>
            
            <div class="book-details">
                <div class="detail-row">
                    <span class="label">👤 Pengarang:</span>
                    <span class="value">{{ $buku->pengarang ?? 'Tidak diketahui' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="label">🏢 Penerbit:</span>
                    <span class="value">{{ $buku->penerbit ?? 'Tidak diketahui' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="label">📅 Tahun Terbit:</span>
                    <span class="value">{{ $buku->tahun_terbit ?? 'Tidak diketahui' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="label">📄 Halaman:</span>
                    <span class="value">{{ $buku->halaman ?? 'Tidak diketahui' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="label">🏷️ Kategori:</span>
                    <span class="value">{{ $buku->subKategoris->kategoris->nama_kategori ?? 'Tidak ada kategori' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="label">📂 Sub Kategori:</span>
                    <span class="value">{{ $buku->subKategoris->nama_sub_kategori ?? 'Tidak ada sub kategori' }}</span>
                </div>
                
                @if($buku->stocks)
                <div class="detail-row">
                    <span class="label">📦 Stok:</span>
                    <span class="value stock-info">
                        @if($buku->stocks->stock > 0)
                            <span class="stock-available">✅ {{ $buku->stocks->stock }} tersedia</span>
                        @else
                            <span class="stock-unavailable">❌ Tidak tersedia</span>
                        @endif
                    </span>
                </div>
                @endif
            </div>
            
            @if($buku->sinopsis)
            <div class="synopsis-section">
                <h3>📖 Sinopsis</h3>
                <p>{{ $buku->sinopsis }}</p>
            </div>
            @endif
            
            <div class="action-section">
                @if($buku->stocks && $buku->stocks->stock > 0 && $buku->stocks->status === 'tersedia')
                    <a href="{{ route('user.peminjaman.create', $buku->stocks->id) }}" class="btn btn-primary btn-large">
                        📚 Pinjam Buku
                    </a>
                @else
                    <button class="btn btn-disabled btn-large" disabled>
                        ❌ Tidak Tersedia
                    </button>
                @endif
                
                <a href="{{ route('user.buku.index') }}" class="btn btn-secondary">
                    ← Kembali ke Daftar Buku
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.book-detail-container {
    max-width: 1000px;
    margin: 0 auto;
}

.book-detail-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
}

.book-image-section {
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.book-cover {
    width: 100%;
    max-width: 250px;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.no-image-large {
    font-size: 5rem;
    color: #ccc;
}

.book-info-section {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.book-header {
    border-bottom: 2px solid #eee;
    padding-bottom: 1rem;
}

.book-header h1 {
    color: #333;
    margin-bottom: 0.5rem;
    font-size: 1.8rem;
}

.book-code {
    background: #667eea;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.book-details {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.detail-row {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.label {
    font-weight: 600;
    color: #555;
    min-width: 120px;
}

.value {
    color: #333;
}

.stock-available {
    color: #28a745;
    font-weight: 600;
}

.stock-unavailable {
    color: #dc3545;
    font-weight: 600;
}

.synopsis-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.synopsis-section h3 {
    margin-bottom: 1rem;
    color: #333;
}

.synopsis-section p {
    line-height: 1.6;
    color: #555;
}

.action-section {
    display: flex;
    gap: 1rem;
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid #eee;
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1rem;
    font-weight: 600;
}

.btn-disabled {
    background: #6c757d;
    cursor: not-allowed;
    opacity: 0.6;
}

.btn-disabled:hover {
    background: #6c757d;
    transform: none;
}

@media (max-width: 768px) {
    .book-detail-card {
        grid-template-columns: 1fr;
        margin: 1rem;
    }
    
    .book-image-section {
        padding: 1rem;
    }
    
    .book-cover {
        max-width: 200px;
    }
    
    .action-section {
        flex-direction: column;
    }
    
    .detail-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .label {
        min-width: auto;
    }
}
</style>
@endsection
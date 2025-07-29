@extends('layouts.user')

@section('title', 'Cari Buku')

@section('content')
<div class="card">
    <h2>📚 Koleksi Buku</h2>
    
    <!-- Search & Filter -->
    <div class="search-section">
        <form method="GET" class="search-form">
            <div class="search-inputs">
                <input type="text" name="search" placeholder="Cari judul buku, pengarang, atau penerbit..." value="{{ request('search') }}">
                <select name="kategori">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">🔍 Cari</button>
            </div>
        </form>
    </div>
    
    <!-- Books Grid -->
    <div class="books-grid">
        @forelse($bukus as $buku)
        <div class="book-card">
            <div class="book-image">
                @if($buku->foto)
                    <img src="{{ asset('storage/' . $buku->foto) }}" alt="{{ $buku->judul_buku }}">
                @else
                    <div class="no-image">📖</div>
                @endif
            </div>
            
            <div class="book-info">
                <h3>{{ $buku->judul_buku }}</h3>
                <p class="author">👤 {{ $buku->pengarang ?? 'Tidak diketahui' }}</p>
                <p class="publisher">🏢 {{ $buku->penerbit ?? 'Tidak diketahui' }}</p>
                <p class="year">📅 {{ $buku->tahun_terbit ?? 'Tidak diketahui' }}</p>
                <p class="category">🏷️ {{ $buku->subKategoris->nama_sub_kategori ?? 'Tidak ada kategori' }}</p>
                
                <div class="book-actions">
                    <a href="{{ route('user.buku.show', $buku) }}" class="btn btn-primary">Detail</a>
                    @if($buku->stocks && $buku->stocks->stock > 0)
                        <span class="stock-available">✅ Tersedia ({{ $buku->stocks->stock }})</span>
                    @else
                        <span class="stock-unavailable">❌ Tidak Tersedia</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="no-books">
            <p>📚 Tidak ada buku yang ditemukan</p>
        </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    @if($bukus->hasPages())
        <div class="pagination-wrapper">
            {{ $bukus->links() }}
        </div>
    @endif
</div>

<style>
.search-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.search-inputs {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.search-inputs input,
.search-inputs select {
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 0.9rem;
}

.search-inputs input {
    flex: 2;
}

.search-inputs select {
    flex: 1;
}

.books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.book-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.book-card:hover {
    transform: translateY(-5px);
}

.book-image {
    height: 200px;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.book-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    font-size: 3rem;
    color: #ccc;
}

.book-info {
    padding: 1rem;
}

.book-info h3 {
    margin-bottom: 0.5rem;
    color: #333;
    font-size: 1.1rem;
}

.book-info p {
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
    color: #666;
}

.book-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #eee;
}

.stock-available {
    color: #28a745;
    font-weight: 500;
    font-size: 0.8rem;
}

.stock-unavailable {
    color: #dc3545;
    font-weight: 500;
    font-size: 0.8rem;
}

.no-books {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    color: #666;
}

@media (max-width: 768px) {
    .search-inputs {
        flex-direction: column;
    }
    
    .search-inputs input,
    .search-inputs select {
        width: 100%;
    }
    
    .books-grid {
        grid-template-columns: 1fr;
    }
    
    .book-actions {
        flex-direction: column;
        gap: 0.5rem;
        align-items: stretch;
    }
}
</style>
@endsection
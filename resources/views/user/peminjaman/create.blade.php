@extends('layouts.user')

@section('title', 'Pinjam Buku')

@section('content')
<div class="form-container">
    <div class="form-card">
        <h2>📚 Form Peminjaman Buku</h2>
        
        @if($stock)
        <div class="book-preview">
            <div class="book-preview-image">
                @if($stock->buku->foto)
                    <img src="{{ asset('storage/' . $stock->buku->foto) }}" alt="{{ $stock->buku->judul_buku }}">
                @else
                    <div class="no-image">📖</div>
                @endif
            </div>
            <div class="book-preview-info">
                <h3>{{ $stock->buku->judul_buku }}</h3>
                <p>👤 {{ $stock->buku->pengarang ?? 'Tidak diketahui' }}</p>
                <p>📦 Stok tersedia: <strong>{{ $stock->stock }}</strong></p>
            </div>
        </div>
        @endif
        
        <form method="POST" action="{{ route('user.peminjaman.store') }}" class="peminjaman-form">
            @csrf
            
            @if($stock)
                <input type="hidden" name="id_stock" value="{{ $stock->id }}">
            @endif
            
            <div class="form-group">
                <label for="tanggal_pinjam">📅 Tanggal Pinjam:</label>
                <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" 
                       value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" 
                       min="{{ date('Y-m-d') }}" required>
                @error('tanggal_pinjam')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="tanggal_kembali">📅 Tanggal Kembali:</label>
                <input type="date" id="tanggal_kembali" name="tanggal_kembali" 
                       value="{{ old('tanggal_kembali') }}" 
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                @error('tanggal_kembali')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="jumlah">📦 Jumlah Buku:</label>
                <input type="number" id="jumlah" name="jumlah" 
                       value="{{ old('jumlah', 1) }}" 
                       min="1" max="{{ $stock ? $stock->stock : 1 }}" required>
                @error('jumlah')
                    <div class="error">{{ $message }}</div>
                @enderror
                @if($stock)
                    <small class="help-text">Maksimal {{ $stock->stock }} buku</small>
                @endif
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large">
                    ✅ Ajukan Peminjaman
                </button>
                <a href="{{ $stock ? route('user.buku.show', $stock->buku) : route('user.buku.index') }}" 
                   class="btn btn-secondary">
                    ← Batal
                </a>
            </div>
        </form>
        
        <div class="info-box">
            <h4>ℹ️ Informasi Peminjaman</h4>
            <ul>
                <li>Peminjaman akan diproses oleh admin</li>
                <li>Anda akan mendapat notifikasi status peminjaman</li>
                <li>Maksimal peminjaman 7 hari</li>
                <li>Harap kembalikan buku tepat waktu</li>
            </ul>
        </div>
    </div>
</div>

<style>
.form-container {
    max-width: 600px;
    margin: 0 auto;
}

.form-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.form-card h2 {
    text-align: center;
    margin-bottom: 2rem;
    color: #333;
}

.book-preview {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 2rem;
    border-left: 4px solid #667eea;
}

.book-preview-image {
    width: 80px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 5px;
}

.book-preview-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 5px;
}

.no-image {
    font-size: 2rem;
    color: #ccc;
}

.book-preview-info h3 {
    margin-bottom: 0.5rem;
    color: #333;
}

.book-preview-info p {
    margin-bottom: 0.25rem;
    color: #666;
    font-size: 0.9rem;
}

.peminjaman-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-weight: 600;
    color: #333;
}

.form-group input {
    padding: 0.75rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-group input:focus {
    outline: none;
    border-color: #667eea;
}

.help-text {
    color: #666;
    font-size: 0.8rem;
}

.error {
    color: #dc3545;
    font-size: 0.8rem;
    font-weight: 500;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    flex: 1;
}

.info-box {
    margin-top: 2rem;
    padding: 1.5rem;
    background: #e3f2fd;
    border-radius: 10px;
    border-left: 4px solid #2196f3;
}

.info-box h4 {
    margin-bottom: 1rem;
    color: #1976d2;
}

.info-box ul {
    margin: 0;
    padding-left: 1.5rem;
}

.info-box li {
    margin-bottom: 0.5rem;
    color: #555;
}

@media (max-width: 768px) {
    .form-container {
        margin: 1rem;
    }
    
    .form-card {
        padding: 1.5rem;
    }
    
    .book-preview {
        flex-direction: column;
        text-align: center;
    }
    
    .book-preview-image {
        align-self: center;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<script>
// Auto set tanggal kembali 7 hari setelah tanggal pinjam
document.getElementById('tanggal_pinjam').addEventListener('change', function() {
    const tanggalPinjam = new Date(this.value);
    const tanggalKembali = new Date(tanggalPinjam);
    tanggalKembali.setDate(tanggalKembali.getDate() + 7);
    
    const tanggalKembaliInput = document.getElementById('tanggal_kembali');
    tanggalKembaliInput.value = tanggalKembali.toISOString().split('T')[0];
    tanggalKembaliInput.min = tanggalKembali.toISOString().split('T')[0];
});
</script>
@endsection
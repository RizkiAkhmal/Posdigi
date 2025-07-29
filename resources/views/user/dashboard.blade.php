@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')
<div class="welcome-section">
    <h1>Selamat Datang, {{ auth()->user()->name }}!</h1>
    <p>Kelola peminjaman buku Anda dengan mudah</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📚</div>
        <div class="stat-info">
            <h3>{{ $totalPeminjaman }}</h3>
            <p>Total Peminjaman</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-info">
            <h3>{{ $pendingPeminjaman }}</h3>
            <p>Menunggu Persetujuan</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-info">
            <h3>{{ $approvedPeminjaman }}</h3>
            <p>Sedang Dipinjam</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📖</div>
        <div class="stat-info">
            <h3>{{ $totalBuku }}</h3>
            <p>Buku Tersedia</p>
        </div>
    </div>
</div>

<div class="quick-actions">
    <h2>Aksi Cepat</h2>
    <div class="action-buttons">
        <a href="{{ route('user.buku.index') }}" class="btn btn-primary">
            <i>📚</i> Cari Buku
        </a>
        <a href="{{ route('user.peminjaman.index') }}" class="btn btn-secondary">
            <i>📋</i> Riwayat Peminjaman
        </a>
    </div>
</div>

<div class="recent-activity">
    <h2>Aktivitas Terbaru</h2>
    @if($recentPeminjaman->count() > 0)
        <div class="activity-list">
            @foreach($recentPeminjaman as $peminjaman)
            <div class="activity-item">
                <div class="activity-icon">
                    @if($peminjaman->status == 'pending')
                        <span class="status-pending">⏳</span>
                    @elseif($peminjaman->status == 'approved')
                        <span class="status-approved">✅</span>
                    @elseif($peminjaman->status == 'rejected')
                        <span class="status-rejected">❌</span>
                    @else
                        <span class="status-returned">📚</span>
                    @endif
                </div>
                <div class="activity-content">
                    <h4>{{ $peminjaman->stock->buku->judul_buku }}</h4>
                    <p>Status: <span class="status {{ $peminjaman->status }}">{{ ucfirst($peminjaman->status) }}</span></p>
                    <small>{{ $peminjaman->created_at->diffForHumans() }}</small>
                </div>
                <div class="activity-action">
                    <a href="{{ route('user.peminjaman.show', $peminjaman) }}" class="btn btn-sm">Detail</a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p class="no-activity">Belum ada aktivitas peminjaman</p>
    @endif
</div>
@endsection
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';
    protected $fillable = [
        'id_peminjaman',
        'nama_pengembali',
        'tanggal_pinjam',
        'tanggal_kembali',
        'jumlah_kembali',
        'kondisi_buku',
        'biaya_denda',
        'status'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'foto',
        'kode_buku',
        'judul_buku',
        'penerbit',
        'pengarang',
        'halaman',
        'sinopsis',
        'tahun_terbit',
        'id_sub_kategori'
    ];

    public function subKategoris()
    {
        return $this->belongsTo(SubKategori::class, 'id_sub_kategori');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'id_buku');
    }
}


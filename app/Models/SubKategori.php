<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_sub_kategori',
        'id_kategori',
    ];

    public function kategoris()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'id_sub_kategori');
    }
}

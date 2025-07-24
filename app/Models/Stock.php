<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_buku',
        'stock',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($stock) {
            $stock->status = $stock->stock > 0 ? 'tersedia' : 'habis';
        });
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_stock');
    }
}



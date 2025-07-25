<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'id_user',
        'id_stock',
        'tanggal_pinjam',
        'tanggal_kembali',
        'jumlah',
        'status'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'id_stock');
    }
}



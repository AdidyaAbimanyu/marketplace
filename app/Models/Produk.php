<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Nama tabel

    protected $fillable = [
        'nama_produk',
        'stok_produk',
        'harga_produk',
        'review_produk',
        'rating_produk',
        'gambar_produk',
        'id_penjual',
    ];

    public function penjual()
    {
        return $this->belongsTo(Penjual::class, 'id_penjual');
    }
}

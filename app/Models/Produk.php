<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = ['nama_produk', 'kategori_produk', 'deskripsi_produk', 'jumlah_review_produk', 'rating_produk', 'stok_produk', 'harga_produk', 'id_pengguna', 'gambar_produk'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_produk');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_produk');
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'id_produk');
    }
}

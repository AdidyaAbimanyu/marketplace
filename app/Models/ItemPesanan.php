<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPesanan extends Model
{
    use HasFactory;

    protected $table = 'item_pesanan';

    protected $fillable = [
        'id_detail_pesanan',
        'id_produk',
        'nama_produk',
        'quantity',
        'harga_produk',
        'subtotal',
    ];

    public function detailPesanan()
    {
        return $this->belongsTo(DetailPesanan::class, 'id_detail_pesanan', 'id_detail_pesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}

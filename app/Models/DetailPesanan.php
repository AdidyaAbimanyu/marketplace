<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail_pesanan';
    protected $fillable = ['status_detail_pesanan', 'total_harga', 'id_pengguna', 'address'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function items()
    {
        return $this->hasMany(ItemPesanan::class, 'id_detail_pesanan');
    }
}

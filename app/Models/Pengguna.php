<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    protected $keyType = 'int'; // Pastikan primary key adalah integer
    public $incrementing = true; // Pastikan primary key auto-increment
    protected $fillable = ['nama_pengguna', 'username_pengguna', 'alamat_pengguna', 'password', 'role'];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_pengguna');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_pengguna');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pengguna');
    }
}

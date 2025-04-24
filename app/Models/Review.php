<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';
    protected $primaryKey = 'id_review';
    protected $fillable = ['isi_review', 'rating_review', 'id_produk', 'id_pengguna'];
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}

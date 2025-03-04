<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pembeli extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pembeli';

    protected $fillable = [
        'nama', // Sesuai dengan migrasi
        'alamat', // Sesuai dengan migrasi
        'username_pembeli', // Perbaikan typo
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}

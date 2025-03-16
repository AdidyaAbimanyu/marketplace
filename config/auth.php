<?php

return [

    'defaults' => [
        'guard' => 'web', // Gunakan guard web bawaan
        'passwords' => 'pengguna',
    ],

    'guards' => [
        'web' => [ // Gunakan `web`, bukan `pengguna`
            'driver' => 'session',
            'provider' => 'pengguna', // Sesuaikan provider dengan tabel pengguna
        ],
    ],

    'providers' => [
        'pengguna' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pengguna::class,
        ],
    ],

    'passwords' => [
        'pengguna' => [
            'provider' => 'pengguna',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];

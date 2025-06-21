<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Keranjang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $cartCount = Keranjang::where('id_pengguna', auth()->id())->count();
                $view->with('cartCount', $cartCount);

                if (auth()->user()->role === 'admin') {
                    $pesananMenunggu = DB::table('detail_pesanan')
                        ->join('produk', 'detail_pesanan.id_produk', '=', 'produk.id_produk')
                        ->select('detail_pesanan.*', 'produk.nama_produk')
                        ->where('status_detail_pesanan', 'waiting_to_approve')
                        ->get();

                    $waitingCount = $pesananMenunggu->count();

                    $view->with('pesananMenunggu', $pesananMenunggu)
                        ->with('waitingCount', $waitingCount);
                }
            }
        });

        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;


class PembeliController extends Controller
{
    public function index()
    {
        $featuredProducts = Produk::orderBy('rating_produk', 'desc')->take(7)->get();

        return view('home', compact('featuredProducts'));
    }
}

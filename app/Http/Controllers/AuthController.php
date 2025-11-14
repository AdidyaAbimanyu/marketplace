<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function auth()
    {
        return view('auth');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            dd(Auth::user()); // ➜ Lihat hasilnya!
            return redirect('/');
        }

        dd('Auth failed'); // Debug
    }


    public function register(Request $request)
    {
        // Cek apakah username sudah digunakan
        if (Pengguna::where('username_pengguna', $request->username_pengguna)->exists()) {
            session()->flash('error', 'Username sudah digunakan, silakan pilih username lain.');
            return back()->withInput();
        }

        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required|string|max:255',
            'username_pengguna' => 'required|string|max:255',
            'alamat_pengguna' => 'required|string|max:255',
            'password' => 'required|confirmed',
            'role' => 'required|in:pembeli,penjual',
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Registrasi gagal! Periksa kembali data Anda.');
            return back()->withErrors($validator)->withInput();
        }

        Pengguna::create([
            'nama_pengguna' => $request->nama_pengguna,
            'username_pengguna' => $request->username_pengguna,
            'alamat_pengguna' => $request->alamat_pengguna,
            'password' => $request->password,
            'role' => $request->role,
        ]);

        session()->flash('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->route('auth');
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('success', 'Logout berhasil!');
        return redirect()->route('home');
    }
}

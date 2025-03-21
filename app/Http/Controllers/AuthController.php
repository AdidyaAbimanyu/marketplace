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
            'username_pengguna' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['username_pengguna' => $credentials['username_pengguna'], 'password' => $credentials['password']])) {
            return redirect()->route('home');
        }

        session()->flash('error', 'Username atau password salah.');
        return back();
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required|string|max:255',
            'username_pengguna' => 'required|string|max:255|unique:pengguna,username_pengguna',
            'alamat_pengguna' => 'required|string|max:255',
            'password' => 'required|confirmed',
            'role' => 'required|in:pembeli,penjual',
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Registrasi gagal! Pastikan semua data diisi dengan benar.');
            return back()->withErrors($validator)->withInput();
        }

        Pengguna::create([
            'nama_pengguna' => $request->nama_pengguna,
            'username_pengguna' => $request->username_pengguna,
            'alamat_pengguna' => $request->alamat_pengguna,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        session()->flash('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->route('auth');
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('success', 'Logout berhasil!');
        return redirect()->route('auth');
    }

}

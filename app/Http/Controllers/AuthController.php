<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role' => 'required|in:Penjual,Pembeli',
        ]);

        $credentials = $request->only('username', 'password');
        $role = $request->role;

        if ($role === 'Penjual') {
            $user = Penjual::where('username', $credentials['username'])->first();
        } else {
            $user = Pembeli::where('username', $credentials['username'])->first();
        }

        if ($user && Hash::check($credentials['password'], $user->password)) {
            if ($role === 'Penjual') {
                Auth::guard('penjual')->login($user);
            } else {
                Auth::guard('pembeli')->login($user);
            }

            session(['role' => $role]); // Menyimpan role dalam session
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:' . ($request->role === 'Penjual' ? 'penjual' : 'penjual'),
            'password' => 'required|min:6',
            'role' => 'required|in:Penjual,Pembeli',
        ]);

        if ($request->role === 'Penjual') {
            Penjual::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
        } else {
            Pembeli::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('auth')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush(); // Hapus semua session termasuk role

        return redirect()->route('auth')->with('success', 'Anda telah logout.');
    }
}

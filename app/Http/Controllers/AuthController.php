<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pembeli;
use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function auth()
    {
        return view('auth');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        $user = Admin::where('username', $credentials['username'])->first();
        $guard = 'admin';

        if (!$user) {
            $user = Penjual::where('username', $credentials['username'])->first();
            $guard = 'penjual';
        }

        if (!$user) {
            $user = Pembeli::where('username', $credentials['username'])->first();
            $guard = 'pembeli';
        }

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::guard($guard)->login($user);
            session(['role' => $guard]);

            if ($guard === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai Admin!');
            } elseif ($guard === 'penjual') {
                return redirect()->route('penjual.dashboard')->with('success', 'Login berhasil sebagai Penjual!');
            } else {
                return redirect()->route('home')->with('success', 'Login berhasil sebagai Pembeli!');
            }
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $penjualExists = DB::table('penjual')->where('username', $value)->exists();
                    $pembeliExists = DB::table('pembeli')->where('username', $value)->exists();
                    if ($penjualExists || $pembeliExists) {
                        session()->flash('error', 'Username sudah digunakan. Silakan pilih username lain.');
                        $fail('Username sudah digunakan.');
                    }
                }
            ],
            'password' => 'required|min:6',
            'role' => 'required|in:Penjual,Pembeli',
        ]);

        if (session()->has('error')) {
            return back()->withInput();
        }

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
        session()->flush();

        return redirect()->route('auth')->with('success', 'Anda telah logout.');
    }
}

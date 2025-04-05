<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Hash;
use Illuminate\Http\Request;
use Validator;

class AdministratorController extends Controller
{
    public function dashboard()
    {
        $pengguna = Pengguna::all();
        return view('admin.dashboard', compact('pengguna'));
    }

    public function add()
    {
        return view('admin.add');
    }

    public function store(Request $request)
    {

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
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        session()->flash('success', 'Registrasi berhasil!.');
        return redirect()->route('admin.dashboard')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('admin.edit', compact('pengguna'));
    }

    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'username_pengguna' => 'required|string|max:255|unique:pengguna,username_pengguna,' . $pengguna->id_pengguna . ',id_pengguna',
            'alamat_pengguna' => 'required|string|max:255',
            'password' => 'nullable|string|confirmed',
            'role' => 'required|in:pembeli,penjual,admin',
        ]);

        $pengguna->nama_pengguna = $request->nama_pengguna;
        $pengguna->username_pengguna = $request->username_pengguna;
        $pengguna->alamat_pengguna = $request->alamat_pengguna;
        $pengguna->role = $request->role;

        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        return redirect()->route('admin.dashboard')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function reset($id)
    {
        $user = Pengguna::findOrFail($id);
        $user->password = Hash::make('123'); // default password
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Password berhasil direset ke 123');
    }

    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Pengguna berhasil dihapus');
    }

}

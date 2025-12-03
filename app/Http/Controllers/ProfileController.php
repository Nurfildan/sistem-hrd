<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    // Halaman untuk MENAMPILKAN profil (READ ONLY)
    public function index()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;
        
        if (!$karyawan) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan');
        }
        
        return view('profile.index', compact('karyawan'));
    }

    // Halaman untuk FORM EDIT profil
    public function edit()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;
        
        if (!$karyawan) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan');
        }
        
        return view('profile.edit', compact('karyawan'));
    }

    // Proses UPDATE profil
    public function update(Request $request)
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        $request->validate([
            'nama' => 'required',
            'no_hp' => 'nullable',
            'email' => 'nullable|email',
            'alamat' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only(['nama', 'no_hp', 'email', 'alamat']);

        // Upload foto baru
        if ($request->hasFile('foto')) {
            if ($karyawan->foto && file_exists(public_path('foto_karyawan/' . $karyawan->foto))) {
                unlink(public_path('foto_karyawan/' . $karyawan->foto));
            }

            $file = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto_karyawan'), $namaFile);
            $data['foto'] = $namaFile;
        }

        $karyawan->update($data);

        return redirect()->route('profile.index')->with('success', 'Profile berhasil diperbarui');
    }

    // Delete account (opsional)
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
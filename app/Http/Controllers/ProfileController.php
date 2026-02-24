<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function index()
    {
        $karyawan = Auth::user()->karyawan;

        if (!$karyawan) {
            return redirect()->route('dashboard')
                ->with('error', 'Data karyawan tidak ditemukan');
        }

        return view('profile.index', compact('karyawan'));
    }

    public function edit()
    {
        $karyawan = Auth::user()->karyawan;

        if (!$karyawan) {
            return redirect()->route('profile.index')
                ->with('error', 'Data karyawan tidak ditemukan');
        }

        return view('profile.edit', compact('karyawan'));
    }

    public function update(Request $request)
    {
        $karyawan = Auth::user()->karyawan;

        if (!$karyawan) {
            return redirect()->route('profile.index')
                ->with('error', 'Data karyawan tidak ditemukan');
        }

        $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'nullable|string|max:20',
            'email'  => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'foto'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'nama', 'no_hp', 'email', 'alamat'
        ]);

        if ($request->hasFile('foto')) {
            if (
                $karyawan->foto &&
                file_exists(public_path('foto_karyawan/' . $karyawan->foto))
            ) {
                unlink(public_path('foto_karyawan/' . $karyawan->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto_karyawan'), $filename);

            $data['foto'] = $filename;
        }

        $karyawan->update($data);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }

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

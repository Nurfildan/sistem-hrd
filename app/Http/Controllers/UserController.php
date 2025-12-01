<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('karyawan')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        // ambil semua karyawan yang belum punya akun
        $karyawan = Karyawan::whereDoesntHave('user')->get();

        return view('users.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'nullable|exists:karyawan,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:Admin,HRD,Karyawan',
            'password' => 'required|min:6',
        ]);

        User::create([
            'karyawan_id' => $request->karyawan_id,
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat!');
    }

    public function edit($id)
{
    $user = User::findOrFail($id);
    $karyawan = Karyawan::all(); // kalau mau bisa ganti karyawan-nya

    return view('users.edit', compact('user', 'karyawan'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'karyawan_id' => 'nullable|exists:karyawan,id',
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|in:Admin,HRD,Karyawan',
        'password' => 'nullable|min:6',
    ]);

    $user = User::findOrFail($id);

    $user->update([
        'karyawan_id' => $request->karyawan_id,
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'password' => $request->password ? Hash::make($request->password) : $user->password,
    ]);

    return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
}


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}

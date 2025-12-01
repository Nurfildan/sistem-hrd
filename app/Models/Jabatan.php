<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';
    protected $fillable = ['nama_jabatan', 'gaji_pokok', 'tunjangan'];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class);
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_jabatan' => 'required',
        'gaji_pokok' => 'required',
        'tunjangan' => 'required',
    ]);

    Jabatan::create([
        'nama_jabatan' => $request->nama_jabatan,
        'gaji_pokok' => str_replace('.', '', $request->gaji_pokok),
        'tunjangan' => str_replace('.', '', $request->tunjangan),
    ]);

    return redirect()->route('jabatan.index')->with('success', 'Data jabatan berhasil ditambah');
}


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'nip',
        'nama',
        'jabatan_id',
        'departemen_id',
        'tgl_masuk',
        'status',
        'no_hp',
        'email',
        'alamat',
        'foto',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }
    public function user()
    {
        return $this->hasOne(User::class, 'karyawan_id');
    }

    public function karyawanShift()
{
    return $this->hasMany(KaryawanShift::class, 'karyawan_id');
}

public function absensi()
{
    return $this->hasMany(Absensi::class, 'karyawan_id');
}

public function potongan()
{
    return $this->hasMany(Potongan::class, 'karyawan_id');
}

public function cuti()
{
    return $this->hasMany(Cuti::class);
}


}

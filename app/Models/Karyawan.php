<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    /* =====================
     | RELATIONSHIP
     ===================== */

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function cuti()
    {
        return $this->hasMany(Cuti::class);
    }

    public function penggajian()
    {
        return $this->hasMany(Penggajian::class);
    }

    public function shift()
    {
        return $this->belongsToMany(
            Shift::class,
            'karyawan_shift'
        )->withPivot('tanggal')
         ->withTimestamps();
    }
}

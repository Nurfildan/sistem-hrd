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

    /** RELATIONS */
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

    public function penggajian()
    {
        return $this->hasMany(Penggajian::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}

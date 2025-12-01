<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shift';
    protected $fillable = ['nama_shift', 'jam_mulai', 'jam_selesai', 'keterangan'];

    public function karyawans()
    {
        return $this->belongsToMany(Karyawan::class, 'karyawan_shift')
                    ->withPivot('tanggal')
                    ->withTimestamps();
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}

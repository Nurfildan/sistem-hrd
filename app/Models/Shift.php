<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shift';

    protected $fillable = [
        'nama_shift',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
    ]; 

    /* =====================
     | RELATIONSHIP
     ===================== */

    public function karyawan()
    {
        return $this->belongsToMany(
            Karyawan::class,
            'karyawan_shift'
        )->withPivot('tanggal')
         ->withTimestamps();
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}

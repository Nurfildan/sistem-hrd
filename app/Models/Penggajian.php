<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = 'penggajian';

    protected $fillable = [
        'karyawan_id',
        'nama_karyawan',
        'nama_jabatan',
        'periode',
        'tanggal_penggajian',
        'gaji_pokok',
        'tunjangan',
        'potongan_otomatis',        
        'total_gaji',
        'status_pembayaran',
    ];

    protected $casts = [
        'tanggal_penggajian' => 'date',
    ];

    /* =====================
     | RELATIONSHIP
     ===================== */

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function potongan()
    {
        return $this->hasMany(Potongan::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = 'penggajian';

    protected $fillable = [
        'karyawan_id',
        'periode',
        'tanggal_penggajian',
        'gaji_pokok',
        'tunjangan',
        'potongan_otomatis',
        'potongan_tambahan',
        'total_gaji',
        'status_pembayaran',
    ];

    /** RELATIONS */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function potongan()
    {
        return $this->hasMany(Potongan::class);
    }
}

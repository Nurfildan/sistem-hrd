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
        'bulan',
        'tanggal_penggajian',
        'gaji_pokok',
        'tunjangan',
        'potongan',
        'total_gaji',
        'status_pembayaran'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}

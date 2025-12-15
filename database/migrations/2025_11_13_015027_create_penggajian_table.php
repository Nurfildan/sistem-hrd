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
        'status_pembayaran'
    ];

    protected $casts = [
        'tanggal_penggajian' => 'date',
        'gaji_pokok' => 'decimal:2',
        'tunjangan' => 'decimal:2',
        'potongan_otomatis' => 'decimal:2',
        'potongan_tambahan' => 'decimal:2',
        'total_gaji' => 'decimal:2',
    ];

    /* ================= RELATION ================= */

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function potongan()
    {
        return $this->hasMany(Potongan::class);
    }

    /* ================= HELPER ================= */

    public function hitungTotalGaji()
    {
        $this->potongan_tambahan = $this->potongan()->sum('jumlah');

        $this->total_gaji =
            ($this->gaji_pokok + $this->tunjangan)
            - ($this->potongan_otomatis + $this->potongan_tambahan);

        return $this->total_gaji;
    }
}

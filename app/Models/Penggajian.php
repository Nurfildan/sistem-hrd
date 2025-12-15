<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
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

    // ✅ TAMBAHKAN CASTING
    protected $casts = [
        'gaji_pokok' => 'decimal:2',
        'tunjangan' => 'decimal:2',
        'potongan_otomatis' => 'decimal:2',
        'potongan_tambahan' => 'decimal:2',
        'total_gaji' => 'decimal:2',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function potongan()
    {
        return $this->hasMany(Potongan::class);
    }

    // ✅ PAKSA AMBIL DARI ATTRIBUTES (KOLOM DATABASE)
    public function getGajiPokokFormattedAttribute()
    {
        return number_format($this->attributes['gaji_pokok'] ?? 0, 0, ',', '.');
    }

    public function getTunjanganFormattedAttribute()
    {
        return number_format($this->attributes['tunjangan'] ?? 0, 0, ',', '.');
    }

    public function getPotonganOtomatisFormattedAttribute()
    {
        return number_format($this->attributes['potongan_otomatis'] ?? 0, 0, ',', '.');
    }

    public function getPotonganTambahanFormattedAttribute()
    {
        return number_format($this->attributes['potongan_tambahan'] ?? 0, 0, ',', '.');
    }

    public function getTotalGajiFormattedAttribute()
    {
        return number_format($this->attributes['total_gaji'] ?? 0, 0, ',', '.');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturanPotonganJabatan extends Model
{
    use HasFactory;

    protected $table = 'aturan_potongan_jabatan';

    protected $fillable = [
        'jabatan_id',
        'potongan_hadir',
        'potongan_terlambat',
        'potongan_izin',
        'potongan_sakit',
        'potongan_alpa',
        'potongan_cuti',
    ];

    /** RELATIONS */
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    /**
     * Helper untuk ambil potongan berdasarkan status absensi
     */
    public function getPotonganByStatus(string $status): float
    {
        return match ($status) {
            'Hadir'      => $this->potongan_hadir,
            'Terlambat'  => $this->potongan_terlambat,
            'Izin'       => $this->potongan_izin,
            'Sakit'      => $this->potongan_sakit,
            'Alpa'       => $this->potongan_alpa,
            'Cuti'       => $this->potongan_cuti,
            default      => 0,
        };
    }
}

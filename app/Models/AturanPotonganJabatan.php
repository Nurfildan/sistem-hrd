<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    /* =====================
     | RELATIONSHIP
     ===================== */

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';

    protected $fillable = [
        'nama_jabatan',
        'gaji_pokok',
        'tunjangan',
    ];

    /* =====================
     | RELATIONSHIP
     ===================== */

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class);
    }

    public function aturanPotongan()
    {
        return $this->hasOne(AturanPotonganJabatan::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    protected $table = 'cuti';
    protected $fillable = [
        'karyawan_id', 'tanggal_mulai', 'tanggal_selesai', 'keterangan', 'status'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}

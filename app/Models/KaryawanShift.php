<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KaryawanShift extends Model
{
    use HasFactory;

    protected $table = 'karyawan_shift';

    protected $fillable = [
        'karyawan_id',
        'shift_id',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /* =====================
     | RELATIONSHIP
     ===================== */

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}

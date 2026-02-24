<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Potongan extends Model
{
    use HasFactory;

    protected $table = 'potongan';

    protected $fillable = [
        'penggajian_id',
        'nama_potongan',
        'jumlah',
        'keterangan',
    ];

    /* =====================
     | RELATIONSHIP
     ===================== */

    public function penggajian()
    {
        return $this->belongsTo(Penggajian::class);
    }
}

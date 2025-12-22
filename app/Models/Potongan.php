<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    /** RELATIONS */
    public function penggajian()
    {
        return $this->belongsTo(Penggajian::class);
    }
}

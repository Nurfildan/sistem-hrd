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
        'potongan_per_absen'
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}

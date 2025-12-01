<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Potongan extends Model
{
    use HasFactory;

    protected $table = 'potongan';
    protected $fillable = ['karyawan_id', 'nama_potongan', 'jumlah', 'bulan'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'karyawan_id',
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* =====================
     | RELATIONSHIP
     ===================== */

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function absensiDiubah()
    {
        return $this->hasMany(Absensi::class, 'updated_by');
    }

    public function cutiDisetujui()
    {
        return $this->hasMany(Cuti::class, 'approved_by');
    }

    /* =====================
     | HELPER
     ===================== */

    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    public function isHRD()
    {
        return $this->role === 'HRD';
    }

    public function isKaryawan()
    {
        return $this->role === 'Karyawan';
    }
}

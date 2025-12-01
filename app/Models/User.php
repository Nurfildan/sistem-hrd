<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Kolom yang bisa diisi massal.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'karyawan_id',
    ];

    /**
     * Kolom yang disembunyikan dari array/json.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting otomatis tipe data.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke tabel karyawan.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    /**
     * Cek role user (Admin, HRD, Karyawan).
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}

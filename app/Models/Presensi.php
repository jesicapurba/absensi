<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    
    protected $table = 'presensi';

    protected $fillable = [
    //
    'name',
    'keterangan',
    'jam_masuk',
    'jam_pulang',
    ];

    protected $casts = [
        'jam_masuk' => 'datetime',
        'jam_pulang' => 'datetime', // <--- PENTING
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function isAdmin(): bool
    {
        // Pengecekan apakah nilai kolom 'role' sama dengan 'admin'
        return $this->role === 'admin';
    }
}


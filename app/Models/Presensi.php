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
    'siswa_id',
    'name',
    'jam_masuk',
    'jam_pulang',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}

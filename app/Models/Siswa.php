<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Siswa;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'users_id',
        'nis',
        'name',
        'asal_sekolah',
        'jurusan',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class, 'siswa_id');
    }
}
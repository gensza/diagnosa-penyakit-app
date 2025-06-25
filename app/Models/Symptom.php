<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_gejala',
        'nama_penyakit',
        'tipes_ringan',
        'tipes_menengah',
        'tipes_berat'
    ];
}

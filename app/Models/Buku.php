<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke Model Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // TAMBAHKAN DUA BARIS METHOD INI:
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
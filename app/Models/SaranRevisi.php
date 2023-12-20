<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaranRevisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'isi',
        'berita_id',
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }
}

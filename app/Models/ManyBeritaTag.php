<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManyBeritaTag extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function manyBeritaTag()
    {
        // return $this->belongsToMany(Berita::class, 'berita_tag', 'tag_id', 'berita_id');
        return $this->hasMany(ManyBeritaTag::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Liputan;
use Illuminate\Http\Request;
// Str
use Illuminate\Support\Str;

class ApiUser extends Controller
{
    //
    function uploadBerita(Request $request)
    {
        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kecamatan_id' => $request->kecamatan_id,
            'user_id' => auth()->user()->id,
            'slug' => Str::slug($request->judul),
            'status' => 'draft',
            'image' => 'default.png',
        ];
        $berita = Berita::create($data);
        if ($request->hasFile('image')) {
            $request->file('image')->move('images/berita', $request->file('image')->getClientOriginalName());
            $berita->image = $request->file('image')->getClientOriginalName();
            $berita->save();
        }
        $data = [
            'status' => true,
            'message' => 'Berhasil mengupload berita',
        ];
        return response()->json($data);
    }

    function getLiputanById($id)
    {
        $liputan = Liputan::where('id', $id)->first();

        $data = [
            'data' => $liputan,
            'gambar' => json_decode($liputan->gambar)
        ];
        return response()->json($data);
    }
}

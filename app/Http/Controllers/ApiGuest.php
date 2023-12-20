<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kabupaten;
use Illuminate\Http\Request;

class ApiGuest extends Controller
{
    //
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (auth()->attempt($data)) {
            $user = auth()->user();
            $data = [
                'status' => true,
                'message' => 'Login berhasil',
                'user' => $user,
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => false,
                'message' => 'Login gagal',
            ];
            return response()->json($data);
        }
    }

    public function getBerita()
    {
        $data = [
            'title' => 'Berita',
            'kabupaten' => Kabupaten::all(),
            'berita' => Berita::where('status', 'publish')->orderBy('created_at', 'desc')->get(),
        ];
        return response()->json($data);
    }

    public function getBeritaByKecamatan($kecamatan_id)
    {
        $data = [
            'data' => Berita::where('status', 'publish')->where('kecamatan_id', $kecamatan_id)->orderBy('created_at', 'desc')->get(),
        ];
        return response()->json($data);
    }

    public function getKabupaten()
    {
        $data = [
            'title' => 'Kabupaten',
            'kabupaten' => Kabupaten::all(),
        ];
        return response()->json($data);
    }

    public function getKecamatan(Request $request)
    {
        // dd($request->kabupaten_id);
        $data = [
            'title' => 'Kecamatan',
            'kecamatan' => Kabupaten::find($request->kabupaten_id)->kecamatan,
        ];
        return response()->json($data['kecamatan']);
    }
}

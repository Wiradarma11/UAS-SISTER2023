<?php

use App\Http\Controllers\ApiGuest;
use App\Http\Controllers\ApiUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [ApiGuest::class, 'login'])->name('api.login');

// Route::get('/', [\App\Http\Controllers\ApiController::class, 'index'])->name('api.index');
Route::get('/get-berita', [ApiGuest::class, 'getBerita'])->name('api.get.berita');
Route::get('/get-berita-by-kecamatan/{kecamatan_id}', [ApiGuest::class, 'getBeritaByKecamatan'])->name('api.get.berita.by.kecamatan');
Route::get('/get-kabupaten', [ApiGuest::class, 'getKabupaten'])->name('api.get.kabupaten');
Route::get('/get-kecamatan', [ApiGuest::class, 'getKecamatan'])->name('api.get.kecamatan');
// Route::get('/get-berita-by-id/{id}', [ApiUser::class, 'getBeritaById'])->name('api.get.berita.by.id');

Route::get('/get-liputan-by-id/{id}', [ApiUser::class, 'getLiputanById'])->name('api.get.liputan.by.id');

// Route::middleware('auth:sanctum')->group(function () {
Route::post('/upload-berita', [\App\Http\Controllers\ApiUser::class, 'uploadBerita'])->name('api.upload.berita');
// });

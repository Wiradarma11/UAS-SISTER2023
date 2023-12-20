@extends('layouts.admin.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Liputan | Lihat Liputan</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
            </button>
        </div>
    </div>

    <div class="container mb-3">
        {{-- judul --}}
        <h3 class="mb-3">
            {{ $liputan->judul }}
            {{-- status --}}
            <div class="mt-3">
                Status:
                @if ($liputan->status == 'mengantri')
                    <span class="badge bg-secondary text-light">{{ Str::upper($liputan->status) }}</span>
                @else
                    <span class="badge bg-success text-light">{{ Str::upper($liputan->status) }}</span>
                @endif
            </div>
        </h3>

        {{-- gambar --}}
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @php
                // array string "[\"1.jpg\",\"2.jpg\"]" diubah menjadi array
                $gambars = json_decode($liputan->gambar);
            @endphp
            @foreach ($gambars as $item)
                <div class="col">
                    <div class="card">
                        <img src="{{ asset('/img/liputan/' . $item) }}" class="card-img-top" alt="...">
                    </div>
                </div>
            @endforeach
        </div>

        {{-- isi --}}
        <div class="mt-3">
            {!! $liputan->isi !!}
        </div>

        {{-- tombol kembali --}}
        <div class="mt-3">
            <a href="{{ route('reporter.liputan.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
@endsection

@extends('layouts.admin.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Berita | Detail Berita</h1>
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
        <h1>{{ $berita->judul }}</h1>
        <p class="text-muted">Dibuat pada {{ $berita->created_at->format('d M Y') }}</p>
        <p class="text-muted">Diperbarui pada {{ $berita->updated_at->format('d M Y') }}</p>
        <hr>

        {{-- thumbnail --}}
        <div class="mb-3">
            @if ($berita->gambar != null)
                {{-- slider --}}
                @if (is_array(json_decode($berita->gambar)))
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach (json_decode($berita->gambar) as $item)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img src="{{ asset('img/berita/' . $item) }}" class="d-block w-100"
                                        style="height: 400px; object-fit: cover; object-position: center"
                                        alt="{{ asset('img/berita/' . $item) }}">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden"></span>
                        </button>
                    </div>
                @else
                    <img src="{{ asset('/img/berita/' . json_decode($berita->gambar)) }}" alt="{{ $berita->gambar }}"
                        id="preview" class="img-fluid">
                @endif
            @else
                <img src="" alt="" id="preview" class="img-fluid">
            @endif
        </div>

        {{-- isi berita --}}
        <div class="mb-3">
            {!! $berita->isi !!}
        </div>
    </div>
@endsection

@section('other-js')
    {{-- select2 --}}
    <script>
        $(document).ready(function() {
            $('#kecamatan').select2();
        });
    </script>

    {{-- preview image --}}
    <script>
        function previewImage() {
            const image = document.querySelector('#thumbnail');
            const imgPreview = document.querySelector('#preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>

    <script>
        CKEDITOR.replace('isi', {
            filebrowserUploadUrl: "{{ route('admin.berita.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            // cloudServices_uploadUrl: 'https://your-organization-id.cke-cs.com/easyimage/upload/'
        });
    </script>
@endsection

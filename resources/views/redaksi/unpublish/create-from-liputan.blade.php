@extends('layouts.admin.app')

{{-- @dd($liputans) --}}

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Liputan dan Berita | Tambah Berita</h1>
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
        <form action="{{ route('redaksi.berita-unpublish.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nama_berita1" class="form-label">Judul Berita</label>
                <input type="text" name="judul" class="form-control" id="nama_berita1" aria-describedby="beritaHelp"
                    value="{{ $liputan->judul }}">
                <div id="beritaHelp" class="form-text">
                    Masukkan judul berita.
                </div>
            </div>

            {{-- option for liputan --}}
            <div class="mb-3">
                <label for="liputan" class="form-label">Pilih Liputan</label>
                <select class="form-select" name="liputan_id" id="liputan" aria-label="Default select example"
                    aria-describedby="help">
                    {{-- <option selected disabled>Pilih Liputan</option> --}}
                    @foreach ($liputans as $item)
                        <option value="{{ $item->id }}" {{ $liputan->id == $item->id ? 'selected' : '' }}>
                            {{ $item->judul }}</option>
                    @endforeach
                </select>
                <div id="help" class="form-text">
                    Kategori liputan untuk berita di publikasikan.
                </div>
            </div>

            {{-- Thumbnail berita --}}
            <div class="mb-3">
                <label for="thumbnail" class="form-label">File Foto Liputan</label>
                <input class="form-control" multiple name="gambar[]" type="file" id="thumbnail" accept=".jpg,.png,.jpeg"
                    onchange="previewImage()">
            </div>

            {{-- preview image --}}
            <div class="mb-3">
                <label for="preview" id="images" class="form-label">Preview</label>
                <img src="" alt="" id="preview" class="img-fluid">
                <div class="multiple row row-cols-1 row-cols-md-3 g-4" style="flex-wrap: nowrap; overflow: auto">

                </div>
            </div>

            {{-- download image from liputans --}}
            {{-- preview image --}}
            <div class="mb-3">
                <label class="form-label">Download Image From Reporter</label>
                <div id="images-download" class="row row-cols-1 row-cols-md-6 g-4"
                    style="flex-wrap: nowrap; overflow: auto"></div>
            </div>

            {{-- isi --}}
            <div class="mb-3">
                <label for="isi" class="form-label">Isi Berita</label>
                <div class="row">
                    <div class="col-md-5">
                        {{-- <p>Isi Liputan</p> --}}
                        <div name="liputan" disabled style="width: 100%; height: 300px; overflow-y: auto" id="liputan-text"
                            readonly>
                            {!! $liputan->isi !!}</div>
                    </div>
                    <div class="col-md-7">
                        {{-- <p>Isi yang di telah edit</p> --}}
                        <textarea class="form-control" name="isi" id="isi" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
@endsection

@section('other-js')
    {{-- select2 --}}

    <script>
        $(document).ready(function() {
            $('#liputan').select2();
        });
    </script>

    <script>
        $(document).ready(function() {
            // check if liputan is selected
            $('#liputan').change(function() {
                // get liputan id
                const liputanId = $(this).val();

                // empty #images-download
                $('#images-download').empty();

                // get base url
                const baseUrl = window.location.origin;

                // get element #liputan-text
                const liputanText = document.querySelector('#liputan-text');

                // get data from liputan
                $.ajax({
                    url: baseUrl + "/api/get-liputan-by-id/" + liputanId,
                    method: 'GET',
                    success: function(liputan) {
                        // console.log(liputan);

                        // set value for #nama_berita1
                        $('#nama_berita1').val(liputan.data.judul);

                        // set innerHTML for #isi
                        // hilangkan tag pada isi
                        const isi = liputan.data.isi.replace(/<\/?[^>]+(>|$)/g, "");
                        liputanText.innerHTML = isi;

                        // string to array convert
                        console.log(liputan)

                        // download image
                        // if not array
                        if (liputan.gambar.length != undefined) {
                            for (let i = 0; i < liputan.gambar.length; i++) {
                                // make element for download image in #images-download
                                $('#images-download').append(
                                    `<a href="{{ asset('/img/liputan/') }}/${liputan.gambar[i]}" target="_blank">
                                        <img src="{{ asset('/img/liputan/') }}/${liputan.gambar[i]}" alt="" class="img-fluid img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                                        </a>`
                                );
                            }
                        } else {
                            // make element for download image in #images-download
                            $('#images-download').append(
                                `<a href="{{ asset('/img/liputan/') }}/${liputan.gambar}" target="_blank">
                                    <img src="{{ asset('/img/liputan/') }}/${liputan.gambar}" alt="" class="img-fluid img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                                    </a>`
                            );
                        }
                    }
                });
            });
        });
    </script>

    {{-- preview image --}}
    <script>
        function previewImage() {
            const image = document.querySelector('#thumbnail');
            const imgPreview = document.querySelector('#preview');
            const multiple = document.querySelector('.multiple');

            imgPreview.style.display = 'block';

            console.log(image.files.length);

            // multiple image
            if (image.files.length > 1) {
                for (let i = 0; i < image.files.length; i++) {
                    const oFReader = new FileReader();
                    oFReader.readAsDataURL(image.files[i]);

                    oFReader.onload = function(oFREvent) {
                        // buat image tag setelah didalam div class multiple
                        multiple.innerHTML += '<img src="' + oFREvent.target.result +
                            '" alt="" class="img-fluid" object-fit: cover;">';
                    }
                }
            } else {
                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }
            }
        }
    </script>

    <script>
        CKEDITOR.replace('isi', {
            filebrowserUploadMethod: 'form',
            // buat ckeditor melihat gambar yang di masukkan melewati folder asset app
            // filebrowserBrowseUrl: "{{ asset('/img/berita/') }}",

        });
    </script>
@endsection

@extends('layouts.admin.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Liputan | Edit Liputan</h1>
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
        <form action="{{ route('reporter.liputan.update', $liputan->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nama_berita1" class="form-label">Judul Liputan</label>
                <input type="text" name="judul" class="form-control" id="nama_berita1" aria-describedby="beritaHelp"
                    value="{{ $liputan->judul ?? old('judul') }}">
                <div id="beritaHelp" class="form-text">
                    Masukkan judul berita.
                </div>
            </div>

            {{-- Option Kab --}}
            <div class="mb-3">
                <label for="kabupaten" class="form-label">Pilih Kabupaten</label>
                <select class="form-select" name="kabupaten_id" id="kabupaten" aria-label="Default select example"
                    aria-describedby="help">
                    <option selected value="{{ $liputan->kecamatan->kabupaten->id }}">
                        {{ $liputan->kecamatan->kabupaten->nama_kabupaten }} </option>

                    @php
                        // kecuali kabupaten yang sudah dipilih
                        $kabupaten = App\Models\Kabupaten::where('id', '!=', $liputan->kecamatan->kabupaten->id)->get();
                    @endphp

                    @foreach ($kabupaten as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_kabupaten }}</option>
                    @endforeach
                </select>
                <div id="help" class="form-text">
                    Kategori kabupaten untuk berita di publikasikan.
                </div>
            </div>

            {{-- option untuk pilih kecamatan --}}
            <div class="mb-3">
                <label for="kecamatan" class="form-label">Pilih Kecamatan</label>
                <select class="form-select" name="kecamatan_id" id="kecamatan" aria-label="Default select example"
                    aria-describedby="help">
                    <option selected disabled>Pilih Kecamatan</option>
                </select>
                <div id="help" class="form-text">
                    Kategori kecamatan untuk berita di publikasikan.
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

            {{-- isi --}}
            <div class="mb-3">
                <label for="isi" class="form-label">Isi Berita</label>
                <textarea class="form-control" name="isi" id="isi" rows="3">{{ $liputan->isi ?? old('isi') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
@endsection

@section('other-js')
    {{-- select2 --}}

    <script>
        $(document).ready(function() {
            $('#kabupaten').select2();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#kecamatan').select2();
        });
    </script>

    <script>
        $.ajax({
            url: "{{ route('api.get.kecamatan') }}",
            type: 'GET',
            data: {
                kabupaten_id: {{ $liputan->kecamatan->kabupaten->id ?? old('kabupaten_id') }}
            },
            success: function(response) {
                // console.log(response);
                // check if response is empty
                if (response.length == 0) {
                    // append kecamatan_id
                    $('#kecamatan').append(
                        '<option selected disabled>Pilih Kecamatan</option>'
                    );
                } else {
                    // loop through response
                    $.each(response, function(key, value) {
                        // append kecamatan_id and select the current kecamatan_id
                        if (value.id ==
                            '{{ $liputan->kecamatan->id ?? old('kecamatan_id') }}'
                        ) {
                            $('#kecamatan').append(
                                '<option selected value="' + value.id +
                                '">' + value
                                .nama_kecamatan + '</option>'
                            );
                        } else {
                            $('#kecamatan').append(
                                '<option value="' + value.id + '">' + value
                                .nama_kecamatan + '</option>'
                            );
                        }
                    });
                }
            }
        });

        $(document).ready(function() {
            // check if kabupaten_id is selected
            $('#kabupaten').change(function() {
                // get kabupaten_id
                var kabupaten_id = $(this).val();
                // empty kecamatan_id
                $('#kecamatan').empty();
                // ajax call
                $.ajax({
                    url: "{{ route('api.get.kecamatan') }}",
                    type: 'GET',
                    data: {
                        kabupaten_id: kabupaten_id
                    },
                    success: function(response) {
                        // console.log(response);
                        // check if response is empty
                        if (response.length == 0) {
                            // append kecamatan_id
                            $('#kecamatan').append(
                                '<option selected disabled>Pilih Kecamatan</option>'
                            );
                        } else {
                            // loop through response
                            // append kecamatan_id
                            $('#kecamatan').append(
                                '<option selected disabled>Pilih Kecamatan</option>'
                            );
                            // loop through response
                            $.each(response, function(key, value) {
                                // append kecamatan_id
                                $('#kecamatan').append(
                                    '<option class="' + value.kabupaten_id +
                                    '" value="' +
                                    value.id + '">' + value.nama_kecamatan +
                                    '</option>'
                                );
                            });
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
            filebrowserUploadUrl: "{{ route('reporter.liputan.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            // buat ckeditor melihat gambar yang di masukkan melewati folder asset app
            // filebrowserBrowseUrl: "{{ asset('/img/berita/') }}",

        });
    </script>
@endsection

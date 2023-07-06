@extends('mylayouts.main')

@push('css')
<style>
    .title {
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{ isset($data) ? 'Edit' : 'Tambah' }} Product
    </h2>
</div>
<div class="grid gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box p-5">
            <form action="{{ isset($data) ? route('produk.update', [$data->id]) : route('produk.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($data))
                @method('patch')
                @endif
                <div>
                    <label for="crud-form-1" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control w-full" type="text" name="nama"
                        value="{{ isset($data) ? ($data->nama) : old('nama') }}" placeholder="Masukkan Nama Produk">
                </div>
                @if (!isset($data))
                <div class="div-name-increment">
                    <label for="">Nama Produk increment?</label>
                    <input type="checkbox" name="name_increment" class="check-name-increment form-check-input">
                </div>
                @endif
                <div class="mt-3">
                    <label for="crud-form-1" class="form-label">Merek</label>
                    <input type="text" class="form-control w-full" name="merek"
                        value="{{ isset($data) ? ($data->merek) : old('merek') }}"
                        placeholder="Masukkan Merek Produkmu">
                </div>
                <div class="mt-3">
                    <label for="crud-form-2" class="form-label">Kategori</label>
                    <select data-placeholder="Pilih Kategori Produkmu" class="between-input-item-select"
                        name="kategori_id" id="kategori">
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ isset($data) ? ($data->kategori_id == $kategori->id ?
                            'selected' : '') : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3">
                    <label for="crud-form-2" class="form-label">Sub Kategori</label>
                    <select name="sub_kategori_id" id="subkategori" class="between-input-item-select w-full "
                        class="form-control">
                        <option value="">Pilih Sub Kategori</option>
                        @if (isset($subcategories))
                        @foreach ($subcategories as $subcategorie)
                        <option value="{{ $subcategorie->id }}" {{ isset($data) ? ($data->sub_kategori_id ==
                            $subcategorie->id ? 'selected' : '') : '' }} clas>{{ $subcategorie->nama }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="mt-3">
                    <label for="crud-form-2" class="form-label">Kondisi</label>
                    <select data-placeholder="Pilih Kondisi Dari Produkmu" class="tom-select w-full" name="kondisi"
                        id="">
                        <option value="">Pilih kondisi</option>
                        <option value="B" {{ isset($data) ? ($data->kondisi == 'B' ? 'selected' : '') : '' }}>Baik
                        </option>
                        <option value="KB" {{ isset($data) ? ($data->kondisi == 'KB' ? 'selected' : '') : '' }}>Kurang
                            Baik</option>
                        <option value="RB" {{ isset($data) ? ($data->kondisi == 'RB' ? 'selected' : '') : '' }}>Rusak
                            Berat</option>
                    </select>
                </div>
                @if (!isset($data))
                <div class="mt-3">
                    <label class="form-label">Jumlah</label>
                    <div class="sm:grid grid-cols-3 gap-2">
                        <div class="input-group">
                            <div id="input-group-3" class="input-group-text">Unit</div>
                            <input type="number" name="jumlah" class="form-control"
                                placeholder="Masukkan Jumlah Unit Barang " aria-describedby="input-group-3">
                        </div>
                    </div>
                </div>
                @endif
                <div class="flex flex-col mt-5">
                    <label for="">Keterangan Produk</label>
                    <textarea class="form-control mt-3 p-3" name="ket_produk" id="" cols="10"
                        rows="6">{{ isset($data) ? ($data->ket_produk) : old('ket_produk') }}</textarea>
                </div>
                <div class="flex flex-col mt-5">
                    <label for="">Keterangan Kondisi Produk</label>
                    <textarea class="form-control mt-3 p-3" name="ket_kondisi" id="" cols="10"
                        rows="6">{{ isset($data) ? ($data->ket_kondisi) : old('ket_kondisi') }}</textarea>
                </div>
                <div class="mt-3">
                    <label for="crud-form-1" class="form-label">Sekali Pakai</label>
                    <input type="checkbox" class="form-check-input ml-1" name="sekali_pakai" {{ isset($data) ?
                        ($data->sekali_pakai ? 'checked' : '') : '' }}>
                </div>
                <div class="mt-3">
                    <label for="crud-form-1" class="form-label">Foto</label>
                    <input type="file" class="w-full" name="fotos[]" multiple accept="image/*">
                </div>
                @if (isset($data))
                <div class="flex gap-3">
                    @foreach ($data->fotos as $foto)
                    <div class="div-foto-{{ $foto->id }}">
                        <a href="{{ asset('storage/' . $foto->file) }}" data-fancybox="gallery">
                            <img src="{{ asset('storage/' . $foto->file) }}" alt=""
                                style="object-fit: cover;aspect-ratio: 1/1;margin: 10px;box-shadow: 0 3px 6px #0000001c;width: 8rem;" />
                        </a>
                        <button type="button" onclick="hapusFoto({{ $foto->id }})"
                            class="btn btn-sm btn-danger rounded w-full">Hapus</button>
                    </div>
                    @endforeach
                </div>
                @endif
        </div>
        <div class="mt-5">
            <button type="submit" class="btn btn-primary w-24">Simpan</button>
            <a href="{{ route('produk.index') }}" class="btn btn-danger w-24 mr-1">
                Kembali
            </a>
        </div>
        </form>
    </div>
</div>
</div>

@push('js')
<script>
    $(function() {
// Multiple images preview with JavaScript
    var previewImages = function(input, imgPreviewPlaceholder) {
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };
    $('#images').on('change', function() {
        previewImages(this, 'a.images-preview-div');
    });
});
</script>
<script>
    $('#kategori').change(function (e) {
        if ($(this).val()) {
            $.ajax({
                type: "get",
                url: "{{ route('get.sub') }}" + `/${$(this).val()}`,
                success: function (response) {
                    items = response.datas
                    $('#subkategori').empty().append(`<option value="">Pilih Sub Kategori</option>`)
                    if (response.datas) {
                        var i = 1
                        items.forEach(item => {
                            console.log(item)
                            document.getElementById('subkategori').innerHTML += `<option value="${item.id}">${item.nama}</option>`;                 
                            document.getElementById('subkategori-ts-dropdown').innerHTML += `<div data-selectable="" data-value="${item.id}" class="option active" role="option" id="subkategori-opt-${i}" aria-selected="false">${item.nama}</div>`;
                            i++
                        });
                    }
                }
            });
        }
    });
</script>
@if (!isset($data))
<script>
    $('.check-name-increment').on('change', function () {
        if ($(this).is(':checked')) {
            $('.div-name-increment').append('<input type="number" name="start_increment" placeholder="Mulai" class="form-control mt-3">')
        } else {
            $('.div-name-increment input[type="number"]').remove()
        }
    })

</script>
@endif
@if (isset($data))
<script>
    function hapusFoto(id) {
        if (confirm('Apakah anda yakin?')) {
            $.ajax({
            type: "DELETE",
            url: "{{ route('produk.hapus_foto') }}",
            data: {
                'produk_id': '{{ $data->id }}',
                'foto_id': id
            },
            dataType: "json",
            beforeSend: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function (response) {
                $('.div-foto-' + id).remove();
                showAlert('Berhasil dihapus', 'success')
            },
            error: function (response) {
                console.log(response)
            },
        });
        }
    }
</script>
@endif
@endpush
@endsection
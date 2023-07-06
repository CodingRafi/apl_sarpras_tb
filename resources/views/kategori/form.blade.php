@extends('mylayouts.main')

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{ isset($data) ? 'Edit' : 'Tambah' }} Kategori
    </h2>
</div>
<div class="grid  gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <form action="{{ isset($data) ? route('kategori.update', [$data->id]) : route('kategori.store') }}"
            method="POST">
            @csrf
            @if (isset($data))
            @method('patch')
            @endif
            <div class="intro-y box p-5">
                <div class="container-form">
                    <div>
                        <label for="crud-form-1" class="form-label">Nama Kategori</label>
                        <input id="crud-form-1" type="text"
                            class="form-control w-full @error('nama') border-red-500 @enderror" name="nama"
                            value="{{ isset($data) ? $data->nama : old('nama') }}" placeholder="Nama">
                        @error('nama')
                        <div class="text-red-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="crud-form-2" class="form-label">Jenis</label>
                        <select data-placeholder="Silahkan Pilih"
                            class="tom-select w-full @error('jenis') border-red-500 @enderror" name="jenis" id="jenis"
                            {{ isset($data) ? 'disabled' : '' }}>
                            <option value="-" selected>Silahkan pilih</option>
                            <option value="sarana" {{ isset($data) ? ($data->jenis == 'sarana' ? 'selected' : '') :
                                (old('jenis') == 'sarana' ? 'selected' : '')
                                }}>Sarana
                            </option>
                            <option value="prasarana" {{ isset($data) ? ($data->jenis == 'prasarana' ? 'selected' : '')
                                : (old('jenis') == 'prasarana' ? 'selected' : '')
                                }}>Prasarana</option>
                        </select>
                        @error('jenis')
                        <div class="text-red-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="text-right mt-5">
                    <a href="{{ route('kategori.index') }}">
                        <button type="button" class="btn btn-outline-secondary w-24 mr-1">Kembali</button>
                    </a>
                    <button class="btn btn-primary w-24" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<template id="template_sub_category">
    <div class="sub-category">
        <div class="mt-5">
            <p>Sub category</p>
            <button class="add-sub btn btn-primary mt-3" type="button" onclick="add_sub()">Tambah Sub Category</button>
        </div>
        @if (isset($data))
        @foreach ($data->subcategory as $sub)
        <div class="sub-{{ $sub->id }} mt-5">
            <div class="flex gap-3 items-start">
                <div class="div-sub">
                    <input id="crud-form-1" type="text" class="form-control w-full" placeholder="Sub" required
                        value="{{ $sub->nama }}">
                </div>
                <div class="div-kode">
                    <input id="crud-form-1" type="text" class="form-control w-full" placeholder="Kode"
                        value="{{ $sub->kode }}" required {{ $sub->produk()->count() > 0 ? 'readonly' : '' }}>
                </div>
                <button class="btn btn-warning" type="button" onclick="updateAjax({{ $sub->id }})">edit</button>
                <button class="remove-sub btn btn-danger" type="button"
                    onclick="removeAjax({{ $sub->id }})">Hapus</button>
            </div>
        </div>
        @endforeach
        @endif
        @if (old('sub'))
        @foreach (old('sub') as $key => $sub)
        <div class="sub-{{ $key }} mt-5">
            <div class="flex gap-3 justify-center items-start">
                <div>
                    <input id="crud-form-1" type="text"
                        class="form-control  @error('sub.' . $key) border-red-500 @enderror" placeholder="Sub"
                        required value="{{ $sub }}" name="{{ 'sub[]' }}">
                    @error('sub.' . $key)
                    <div class="text-red-500">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div>
                    <input id="crud-form-1" type="text"
                        class="form-control  @error('kode.' . $key) border-red-500 @enderror"
                        name="{{ 'kode[]' }}" placeholder="Kode" value="{{ old('kode')[$key] }}" required>
                    @error('kode.' . $key)
                    <div class="text-red-500">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button class="remove-sub btn btn-danger" type="button" onclick="remove({{ $key }})">Hapus</button>
            </div>
        </div>
        @endforeach
        @endif
        <div class="mt-5 mb-5">
            <div class="container-sub"></div>
        </div>
    </div>
</template>

@push('js')
<script>
    el = 1;

    function add_sub(){
        $('.container-sub').append(`
            <div class="sub-${el}">
                <div class="flex gap-3 justify-center items-center">
                    <input id="crud-form-1" type="text" class="form-control w-full" name="sub[]" placeholder="Sub" required>
                    <input id="crud-form-1" type="text" class="form-control w-full" name="kode[]" placeholder="Kode" required>
                    <button class="remove-sub btn btn-danger w-24 mr-1" type="button" onclick="remove(${el})">Hapus</button>
                </div>
                <br>
            </div>
        `)
        el++
    }

    function remove(id){
        $('.sub-' + id).remove()
    }

    function updateAjax(id){
        $.ajax({
            type: "POST",
            url: "{{ route('sub-kategori.update') }}" + `/${id}`,
            data: {
                sub: $('.sub-' + id + ' .div-sub input').val(),
                kode: $('.sub-' + id + ' .div-kode input').val()
            },
            dataType: "json",
            beforeSend: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function (response) {
                $('.sub-' + id + ' .text-red-500').remove();
                $('.sub-' + id + ' input').removeClass('border-red-500')
                showAlert('Berhasil diubah', 'success')
            },
            error: function (errors) {
                $('.sub-' + id + ' .text-red-500').remove();
                $('.sub-' + id + ' input').removeClass('border-red-500')
                errs = errors.responseJSON.errors;
                for (const key in errs) {
                    $('.sub-' + id + ' .div-' + key).append(`<div class="text-red-500">${errs[key]}</div>`)
                    $('.sub-' + id + ' .div-' + key + ' input').addClass('border-red-500')
                }
            },
        });
    }

    function removeAjax(id){
        $.ajax({
            type: "DELETE",
            url: "{{ route('sub-kategori.destroy') }}" + `/${id}`,
            data: {
                nama: $('.sub-' + id + ' input').val(),
            },
            dataType: "json",
            beforeSend: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function (response) {
                $('.sub-' + id).remove()
                showAlert('Berhasil dihapus', 'success')
            },
            error: function (response) {
                console.log(response)
            },
        });
    }

    $('#jenis').on('change', function(e){
        if ($(this).val() == 'sarana') {
            $('form .container-form').append($('#template_sub_category').html())
        }else if($(this).val() == 'prasarana' || !$(this).val()){
            $('form .sub-category').remove()
        }else{
            $('form .sub-category').remove()
        }
    })
</script>
@if (isset($data) || old('sub'))
<script>
    $('#jenis').trigger('change');
</script>
@endif
@endpush
@endsection
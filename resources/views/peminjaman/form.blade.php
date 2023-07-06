@extends('mylayouts.main')

@push('css')
<style>
    .title {
        font-weight: 500;
    }

    .kbw-signature {
        width: 100%;
        height: 200px;
    }

    #sig canvas {
        width: 100% !important;
        height: auto;
    }
</style>
<link type="text/css" href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.signature.css') }}">
@endpush

@section('content')
<div class="grid gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="intro-y box p-5">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    {{ isset($data) ? 'Edit' : 'Tambah' }} Peminjaman
                </h2>
            </div>
            <form action="{{ isset($data) ? route('peminjamans.update', $data['id']) : route('peminjamans.store') }}"
                class="form-peminjaman" method="POST">
                @csrf
                @if (isset($data))
                @method('patch')
                @endif
                <x-FormPeminjaman :page="$page" :update="isset($data) ? $data : []" :kelas="$kelas"></x-FormPeminjaman>
                <div class="div-other">
                    <div class="mt-3">
                        <div class="col-md-12">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="between-input-item-select" id="status" onchange="syncStatus()">
                                <option value="pengajuan" {{ isset($data) ? ($data['status']=='pengajuan' ? 'selected' : '' )
                                    : '' }}>Pengajuan</option>
                                <option value="diterima" {{ isset($data) ? ($data['status']=='diterima' ? 'selected' : '' ) : ''
                                    }}>Diterima</option>
                                <option value="ditolak" {{ isset($data) ? ($data['status']=='ditolak' ? 'selected' : '' ) : ''
                                    }}>Ditolak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-5">
                    <a href="{{ route('peminjamans.index') }}">
                        <button type="button" class="btn btn-outline-secondary w-24 mr-1">Kembali</button>
                    </a>
                    <button class="btn btn-primary w-24" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="diterima">
    <div class="div-diterima">
        <div class="mt-3">
            <div class="col-md-12">
                <label for="tgl_peminjaman" class="form-label">Tanggal Peminjaman</label>
                <input type="datetime-local" name="tgl_peminjaman" id="tgl_peminjaman"
                    value="{{ isset($data) ? $data['tgl_peminjaman'] : old('tgl_peminjaman') }}">
            </div>
        </div>
        <div class="mt-3">
            <div class="col-md-12">
                <label for="tgl_pengembalian" class="form-label">Tanggal Pengembalian</label>
                <input type="datetime-local" name="tgl_pengembalian" id="tgl_pengembalian"
                    value="{{ isset($data) ? $data['tgl_pengembalian'] : old('tgl_pengembalian') }}">
            </div>
        </div>
        <div class="form-group mb-2">
            <label for="image" class="form-label">Foto Peminjaman</label>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div id="camera_peminjaman"></div>
                        <br />
                        <input type=button class="btn btn-sm btn-info" value="Take Snapshot"
                            onClick="take_snapshot('.image-peminjaman', 'result-peminjaman')">
                        <input type="hidden" name="image_peminjaman" class="image-peminjaman">
                    </div>
                    <div class="col-md-6">
                        <div id="result-peminjaman">Your captured image will appear here...</div>
                    </div>
                    @if (isset($data) && $data['foto_peminjaman'])
                    <strong>Foto Peminjaman disimpan</strong>
                    <img src="{{ asset('foto_peminjaman/' . $data['foto_peminjaman']) }}" alt="">
                    @endif
                </div>
                @error('image')
                <div class="invalid-feedback d-block">
                    The picture field is required.
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group mb-2">
            <label for="image" class="form-label">Foto Pengembalian</label>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div id="camera_pengembalian"></div>
                        <br />
                        <input type=button class="btn btn-sm btn-info" value="Take Snapshot"
                            onClick="take_snapshot('.image-pengembalian', 'result-pengembalian')">
                        <input type="hidden" name="image_pengembalian" class="image-pengembalian">
                    </div>
                    <div class="col-md-6">
                        <div id="result-pengembalian">Your captured image will appear here...</div>
                    </div>
                    @if (isset($data) && $data['foto_pengembalian'])
                    <strong>Foto Pengembalian disimpan</strong>
                    <img src="{{ asset('foto_pengembalian/' . $data['foto_pengembalian']) }}" alt="">
                    @endif
                </div>
                @error('image')
                <div class="invalid-feedback d-block">
                    The picture field is required.
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group mb-2">
            <label for="ttd" class="form-label">Tanda tangan Peminjaman</label>
            <div class="col-md-12">
                <br />
                <div id="sig"></div>
                <br />
                <button id="clear" class="btn btn-danger">Hapus Tanda Tangan</button>
                <textarea id="signature64" name="ttd" style="display: none"></textarea>
                @if (isset($data) && $data['ttd'])
                <strong>Tanda Tangan disimpan</strong>
                <img src="{{ asset('ttd/' . $data['ttd']) }}" alt="">
                @endif
                @error('ttd')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        @if (isset($data) && $data['status'] == 'diterima')
        <div class="mt-3">
            <label for="crud-form-1" class="form-label">Pengajuan selesai</label>
            <input type="checkbox" name="status_pengembalian" {{ isset($data) ? ($data['status_pengembalian'] ?
            'checked' : '') : '' }}>
        </div>
        @endif
        <script>
            Webcam.set({
                    width: 280,
                    height: 200,
                    image_format: 'jpeg',
                    jpeg_quality: 90
                });
                
                Webcam.attach('#camera_peminjaman');
                Webcam.attach('#camera_pengembalian');
        
                function take_snapshot(result, preview) {
                    Webcam.snap(function(data_uri) {
                        $(result).val(data_uri);
                        document.getElementById(preview).innerHTML = '<img src="' + data_uri + '"/>';
                    });
                }
                var canvas = document.getElementById('signature-pad');
                var sig = $('#sig').signature({
                    syncField: '#signature64',
                    syncFormat: 'PNG'
                });
        
                $('#clear').click(function(e) {
                    e.preventDefault();
                    sig.signature('clear');
                    $("#signature64").val('');
                });
        </script>
    </div>
</template>
<template id="ditolak">
    <div class="div-ditolak">
        <div class="mt-3">
            <div class="col-md-12">
                <label for="ket" class="form-label">Keteragan</label>
                <textarea name="ket" id="ket" cols="30" rows="10" class="form-control">{{ isset($data) ? $data['ket'] : '' }}</textarea>
            </div>
        </div>
    </div>
</template>

<h1></h1>
@endsection

@push('js')
@include('peminjaman.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.signature.js') }}"></script>
<script>
    function syncStatus(value = null){
        let status = value ?? $('.div-other #status').val();
        if (status == 'diterima') {
            $('.div-other').append($('#diterima').html())
            $('.div-other .div-ditolak').remove()
        }else if(status == 'ditolak'){
            $('.div-other').append($('#ditolak').html())
            $('.div-other .div-diterima').remove()
        }else{
            $('.div-other .div-ditolak').remove()
            $('.div-other .div-diterima').remove()
        }
    }
</script>
@if (isset($data))
<script>
    syncStatus("{{ $data['status'] }}")
</script>
@endif
@endpush
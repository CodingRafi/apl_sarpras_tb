@extends('mylayouts.main')

@push('css')
<style>
    .title {
        font-weight: 500;
    }

</style>
@endpush

@section('content')
<div class="content">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <h4><strong>Dashboard</strong></h4>
            </div>
            @if (Auth::user()->hasRole('super_admin'))
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Tahun Ajaran</h5>
                            <p class="card-text" style="font-size: 2rem">{{ $countTahunAjaran }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Agama</h5>
                            <p class="card-text" style="font-size: 2rem">{{ $countAgama }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Role</h5>
                            <p class="card-text" style="font-size: 2rem">{{ $countRole }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="card mb-3" style="min-height: 17rem;overflow: auto;">
                <div class="card-body">
                    <div class="title" style="display: flex; justify-content: space-between">
                        <h4 class="card-title">Profile Sekolah</h4>
                        @if (auth()->user()->can('edit_sekolah'))
                        <x-ButtonCustom class="btn btn-warning btn-sm rounded" route="{{ route('sekolah.edit.own') }}">
                            Edit
                        </x-ButtonCustom>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-9">
                            <table class="table table-responsive table-borderless">
                                <tr>
                                    <td class="title">Nama Sekolah</td>
                                    <td>:</td>
                                    <td>{{ Auth::user()->sekolah->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="title">NPSN</td>
                                    <td>:</td>
                                    <td>{{ Auth::user()->sekolah->npsn }}</td>
                                </tr>
                                <tr>
                                    <td class="title">Kepala Sekolah</td>
                                    <td>:</td>
                                    <td>{{ Auth::user()->sekolah->kepala_sekolah }}</td>
                                </tr>
                                <tr>
                                    <td class="title">Alamat</td>
                                    <td>:</td>
                                    <td>{{ Auth::user()->sekolah->jalan }},{{ Auth::user()->sekolah->kelurahan->nama }},{{
                                Auth::user()->sekolah->kecamatan->nama }}, {{ Auth::user()->sekolah->kabupaten->nama }}, {{
                                Auth::user()->sekolah->provinsi->nama }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-3">
                            <img src="{{ Auth::user()->sekolah->logo != '/img/tutwuri.png' ? asset('storage/' . Auth::user()->sekolah->logo) : Auth::user()->sekolah->logo }}"
                                alt="" scale="1/1"
                                style="width: 10rem; object-fit: cover; border-radius: 5px; display: block;">
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endsection
    
            @push('js')
            @endpush
        </div>
       
    </div>
</div>

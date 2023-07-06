@extends('mylayouts.main')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="grid gap-6">
            <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                <div class="intro-y box mt-5">
                    <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto capitalize">
                            {{ isset($data) ? 'Edit' : 'Tambah' }} Tahun Ajaran
                        </h2>
                        <a href="{{ route('tahun-ajaran.index') }}" class="btn bg-red-600 text-white px-5">
                            Kembali
                        </a>
                    </div>
                    <form class="p-5"
                        action="{{ (isset($data)) ? route('tahun-ajaran.update', $data->id) : route('tahun-ajaran.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @if (isset($data))
                        @method('patch')
                        @endif
                        @csrf
                        @include('mypartials.tahunajaran')
                        <div class="grid grid-cols-12 gap-x-5">
                            <div class="col-span-12 xl:col-span-12">
                                <div class="mb-3">
                                    <label for="error"
                                        class="block mb-2 text-sm font-medium @error('tahun_awal') text-red-700 dark:text-red-500 @enderror">Tahun
                                        Awal</label>
                                    <input type="number" min="1900" max="2099" step="1"
                                        value="{{ isset($data) ? $data->tahun_awal : date('Y', strtotime(now())) }}"
                                        class="form-control @error('tahun_awal') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                        id="tahun_awal" name="tahun_awal">
                                    @error('tahun_awal')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="error"
                                        class="block mb-2 text-sm font-medium @error('tahun_akhir') text-red-700 dark:text-red-500 @enderror">Tahun
                                        Akhir</label>
                                    <input type="number" min="1900" max="2099" step="1"
                                        value="{{ isset($data) ? $data->tahun_akhir : date('Y', strtotime(now())) + 1 }}"
                                        class="form-control @error('tahun_akhir') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                        id="tahun_akhir" name="tahun_akhir">
                                    @error('tahun_akhir')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-3 flex gap-3">
                                    <label for="error"
                                        class="block mb-2 text-sm font-medium @error('status') text-red-700 dark:text-red-500 @enderror">Status</label>
                                    <input class="form-check-input" type="checkbox" name="status" {{ isset($data) ?
                                        $data->status == 'aktif' ? 'checked' : '' : '' }}>
                                </div>
                            </div>
                            <div class="col-span-12 xl:col-span-12">
                                <div class="mt-3 xl:mt-0">
                                    <button type="submit" class="btn btn-primary px-5 mr-5">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
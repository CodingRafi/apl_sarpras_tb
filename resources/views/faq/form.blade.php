@extends('mylayouts.main')

@push('css')
<style>
    .title {
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="intro-y box">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="font-medium text-base mr-auto">
            {{ isset($data) ? 'Edit' : 'Tambah' }} FAQ
        </h2>
    </div>
    <form action="{{ isset($data) ? route('faq.update', [$data->id]) : route('faq.store') }}" method="post">
        @csrf
        @if (isset($data))
        @method('patch')
        @endif
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div class="mb-3">
                    <label for="error"
                        class="block mb-2 text-sm font-medium @error('judul') text-red-700 dark:text-red-500 @enderror">Judul</label>
                    <input type="text"
                        value="{{ isset($data) ? $data->judul : old('judul') }}"
                        class="form-control @error('judul') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                        id="judul" name="judul">
                    @error('judul')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label
                        class="block mb-2 text-sm font-medium @error('konten') text-red-700 dark:text-red-500 @enderror"
                        for="error">Konten</label>
                    <textarea type="text"
                        class="form-control @error('konten') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                        placeholder="Masukan konten" name="konten" style=" font-size: 15px;"
                        id="konten">{{ isset($data) ? $data->konten : old('konten') }}</textarea>
                    @error('konten')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('faq.index') }}" class="btn btn-danger px-5 ml-3">
                    Kembali
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
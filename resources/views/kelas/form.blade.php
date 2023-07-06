@extends('myLayouts.main')

@section('content')
<div class="intro-y box">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="font-medium text-base mr-auto">
            {{ isset($data) ? 'Edit' : 'Tambah' }} Kelas
        </h2>
    </div>
    <form action="{{ isset($data) ? route('kelas.update', [$data->id]) : route('kelas.store') }}" method="post">
        @csrf
        @if (isset($data))
        @method('patch')
        @endif
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div class="mt-3">
                    <label for="vertical-form-2" class="form-label">Kelas</label>
                    <input id="vertical-form-2" type="text" class="form-control" name="nama"
                        value="{{ isset($data) ? $data->nama : old('nama') }}" placeholder="Kelas">
                </div>
                <button type="submit" class="btn btn-primary mt-5">Simpan</button>
                <a href="{{ route('kelas.index') }}" class="btn px-5 ml-3">
                    Kembali
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
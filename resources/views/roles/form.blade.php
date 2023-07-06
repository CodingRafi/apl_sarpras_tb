@extends('mylayouts.main')

@section('content')
<div class="intro-y box">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="font-medium text-base mr-auto">
            {{ isset($data) ? 'Edit' : 'Tambah' }} Role
        </h2>
    </div>
    <form action="{{ isset($data) ? route('roles.update', [$data->id]) : route('roles.store') }}" method="post">
        @csrf
        @if (isset($data))
        @method('patch')
        @endif
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div class="mb-3 row">
                    <div class="col-md-12">
                        <label for="namaRole" class="block mb-2 text-sm font-medium @error('name') text-red-700 dark:text-red-500 @enderror">Nama Role</label>
                        <input
                            class="form-control @error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                            type="text" value="{{ isset($data) ? $data->name : old('name') }}" id="namaRole"
                            placeholder="Name Role" name="name" {{ isset($data) ? 'disabled' : '' }} />
                        @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="mt-3">
                        <label for="crud-form-2" class="block mb-2 text-sm font-medium @error('permission') text-red-700 dark:text-red-500 @enderror">Hak Akses</label>
                        <select data-placeholder="Pilih Hak Akses Pada Roles Ini" class="form-select w-full @error('permission') bg-red-50 border border-red-500 text-red-900
                        placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700
                        focus:border-red-500 block p-2.5 dark:text-red-500
                        dark:placeholder-red-500 dark:border-red-500 @enderror" multiple name="permission[]"
                            id="permission">
                            @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}" {{ isset($data) ? (in_array($permission->id, $rolePermissions) ? 'selected' : '') : (old('permission') ? in_array($permission->id, old('permission')) ? 'selected' : '' : '') }}>{{ str_replace('_', ' ', $permission->name) }}</option>
                            @endforeach
                        </select>
                        @error('permission')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}
                        </p>
                        @enderror
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('roles.index') }}" class="btn btn-danger px-5 ml-3">
                    Kembali
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
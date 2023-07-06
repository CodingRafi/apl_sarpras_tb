@extends('mylayouts.main')
@push('css')
<style>
    .hidden {
        display: none;
    }
</style>
@endpush
@section('content')
<div class="card">
    <div class="card-body">
        <div class="grid gap-6">
            <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                <div class="intro-y box mt-5">
                    <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            Tambah Sekolah
                        </h2>
                    </div>
                    <form class="p-5"
                        action="{{ isset($sekolah) ? route('sekolah.update', $sekolah->id) : route('sekolah.store') }}"
                        id="regForm" method="post" enctype="multipart/form-data">
                        @csrf
                        @if (isset($sekolah))
                        @method('patch')
                        @endif
                        <div class="grid grid-cols-12 gap-x-5">
                            <div class="col-span-12 xl:col-span-6">
                                <div class="mb-3">
                                    <label
                                        class="block mb-2 text-sm font-medium @error('nama_sekolah') text-red-700 dark:text-red-500 @enderror"
                                        for="error">Nama Sekolah:</label>
                                    <input type="text"
                                        class="form-control @error('nama_sekolah') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror  "
                                        placeholder="Nama Sekolah" name="nama_sekolah"
                                        style="border-radius: 5px; width: 100%"
                                        value="{{ isset($sekolah) ? $sekolah->nama : old('nama_sekolah') }}" required>
                                    @error('nama_sekolah')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label
                                        class="block mb-2 text-sm font-medium @error('kode') text-red-700 dark:text-red-500 @enderror"
                                        for="error">Kode Sekolah:</label>
                                    <input type="text"
                                        class="form-control @error('kode') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror  "
                                        placeholder="Kode Sekolah" name="kode" style="border-radius: 5px; width: 100%"
                                        value="{{ isset($sekolah) ? $sekolah->kode : old('kode') }}" required>
                                    @error('kode')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label
                                        class="block mb-2 text-sm font-medium @error('npsn') text-red-700 dark:text-red-500 @enderror"
                                        for="error">NPSN:</label>
                                    <input type="number"
                                        class="form-control @error('npsn') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                        placeholder="NPSN" name="npsn" style="border-radius: 5px; width: 100%"
                                        value="{{ isset($sekolah) ? $sekolah->npsn :old('npsn') }}" required>
                                    @error('npsn')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label
                                        class="block mb-2 text-sm font-medium @error('kepala_sekolah') text-red-700 dark:text-red-500 @enderror"
                                        for="error">Kepala Sekolah:</label>
                                    <input type="text"
                                        class="form-control @error('kepala_sekolah') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                        placeholder="Kepala Sekolah" name="kepala_sekolah"
                                        style="border-radius: 5px; width: 100%"
                                        value="{{ isset($sekolah) ? $sekolah->kepala_sekolah :old('kepala_sekolah') }}"
                                        required>
                                    @error('kepala_sekolah')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label
                                        class="block mb-2 text-sm font-medium @error('jenjang') text-red-700 dark:text-red-500 @enderror"
                                        for="error">Jenjang:</label>
                                    <select name="jenjang" id="jenjang"
                                        class="form-select text-dark form-control @error('jenjang') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                        style="border-radius: 5px;" required>
                                        <option value="">Pilih Jenjang</option>
                                        <option value="sd" {{ isset($sekolah)? ($sekolah->jenjang =='sd' ? 'selected' :
                                            '') : '' }}>SD</option>
                                        <option value="smp" {{ isset($sekolah)? ($sekolah->jenjang =='smp' ? 'selected'
                                            : '') : '' }}>SMP</option>
                                        <option value="sma" {{ isset($sekolah)? ($sekolah->jenjang =='sma' ? 'selected'
                                            : '') : '' }}>SMA</option>
                                        <option value="smk" {{ isset($sekolah)? ($sekolah->jenjang =='smk' ? 'selected'
                                            : '') : '' }}>SMK</option>
                                    </select>
                                    @error('jenjang')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label
                                        class="block mb-2 text-sm font-medium @error('alamat') text-red-700 dark:text-red-500 @enderror"
                                        for="error">Alamat:</label>
                                    <textarea type="text"
                                        class="form-control @error('alamat') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                        placeholder="Masukan alamat" name="alamat" style=" font-size: 15px;"
                                        id="alamat">{{ isset($sekolah) ? $sekolah->alamat : old('alamat') }}</textarea>
                                    @error('alamat')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label
                                        class="block mb-2 text-sm font-medium @error('jam_masuk') text-red-700 dark:text-red-500 @enderror"
                                        for="error">Jam Masuk:</label>
                                    <input type="time"
                                        class="form-control @error('jam_masuk') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                        placeholder="Masukan jam_masuk" name="jam_masuk"
                                        value="{{ isset($sekolah) ? $sekolah->jam_masuk : old('jam_masuk') }}"
                                        style=" font-size: 15px;" id="jam_masuk">
                                    @error('jam_masuk')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label
                                        class="block mb-2 text-sm font-medium @error('jam_pulang') text-red-700 dark:text-red-500 @enderror"
                                        for="error">Jam Pulang:</label>
                                    <input type="time"
                                        class="form-control @error('jam_pulang') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                        placeholder="Masukan jam_pulang" name="jam_pulang"
                                        value="{{ isset($sekolah) ? $sekolah->jam_pulang : old('jam_pulang') }}"
                                        style=" font-size: 15px;" id="jam_pulang">
                                    @error('jam_pulang')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-12 xl:col-span-6">
                                <div class="mb-3">
                                    <label
                                        class="block mb-2 text-sm font-medium @error('name') text-red-700 dark:text-red-500 @enderror"
                                        for="error">Nama Admin Sekolah:</label>
                                    <input type="text"
                                        class="form-control @error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                        placeholder="Nama" name="name" style="border-radius: 5px; width: 100%"
                                        value="{{ isset($sekolah) ? $sekolah->user->name : old('name') }}"
                                        required>
                                    @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label
                                        class="block mb-2 text-sm font-medium @error('email') text-red-700 dark:text-red-500 @enderror"
                                        for="error">Email:</label>
                                    <input type="email"
                                        class="form-control @error('email') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                        placeholder="Email" name="email" style="border-radius: 5px; width: 100%"
                                        value="{{ isset($sekolah) ? $sekolah->user->email : old('email') }}"
                                        required>
                                    @error('email')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label
                                        class="block mb-2 text-sm font-medium @error('password') text-red-700 dark:text-red-500 @enderror"
                                        for="error">Password:</label>
                                    <input type="password"
                                        class="form-control @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                        placeholder="password" name="password" style="border-radius: 5px; width: 100%"
                                        {{ isset($sekolah)? '' : 'required' }}>
                                    @error('password')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label
                                        class="block mb-2 text-sm font-medium @error('logo') text-red-700 dark:text-red-500 @enderror"
                                        for="error">Logo Sekolah:</label>
                                    <div class="mb-3">
                                        <label class="form-label">Upload Image</label>
                                        <div class="border-2 border-dashed dark:border-darkmode-400 rounded-md pt-4">
                                            <div class="flex flex-wrap px-4">
                                                <div class="w-24 h-24 relative image-fit mb-5 mr-5 cursor-pointer zoom-in"
                                                    id="previewContainer" style="display: none;">
                                                    <img class="rounded-md" id="preview" src="" style=""
                                                        data-action="zoom">
                                                    <div title="Remove this image?"
                                                        class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2"
                                                        onclick="removeImage()"> <i data-lucide="x" class="w-4 h-4"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-4 pb-4 flex items-center cursor-pointer relative">
                                                <i data-lucide="image" class="w-4 h-4 mr-2"></i> <span
                                                    class="text-primary mr-1">Upload a file</span> or drag and drop
                                                <input class="w-full h-full top-0 left-0 absolute opacity-0" type="file"
                                                    name="logo" id="logoInput" onchange="previewImage(event)">
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function previewImage(event) {
                                                var input = event.target;
                                                var reader = new FileReader();
                                                var previewContainer = document.getElementById("previewContainer");
                                                
                                                reader.onload = function(){
                                                    var img = document.getElementById("preview");
                                                    img.src = reader.result;
                                                    previewContainer.style.display = "block";
                                                };
                                                
                                                if (input.files && input.files[0]) {
                                                    reader.readAsDataURL(input.files[0]);
                                                } else {
                                                    var img = document.getElementById("preview");
                                                    img.src = "";
                                                    previewContainer.style.display = "none";
                                                }
                                            }
                                            function removeImage() {
                                            var img = document.getElementById("preview");
                                            var previewContainer = document.getElementById("previewContainer");
                                            var input = document.getElementById("logoInput");
    
                                                 img.src = "";
                                                previewContainer.style.display = "none";
                                                input.value = "";
                                             }
                                    </script>
                                    <style>
                                        .hasImage:hover section {
                                            background-color: rgba(5, 5, 5, 0.4);
                                        }

                                        .hasImage:hover button:hover {
                                            background: rgba(5, 5, 5, 0.45);
                                        }

                                        #overlay p,
                                        i {
                                            opacity: 0;
                                        }

                                        #overlay.draggedover {
                                            background-color: rgba(255, 255, 255, 0.7);
                                        }

                                        #overlay.draggedover p,
                                        #overlay.draggedover i {
                                            opacity: 1;
                                        }

                                        .group:hover .group-hover\:text-blue-800 {
                                            color: #2b6cb0;
                                        }
                                    </style>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <button class="btn btn-primary w-24" type="submit">Simpan</button>
                            <a href="{{ route('sekolah.index') }}">
                                <button type="button"
                                    class="btn btn-danger w-24 mr-1">Kembali</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
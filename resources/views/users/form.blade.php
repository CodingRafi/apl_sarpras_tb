<div class="grid gap-6">
    <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
        <div class="intro-y box mt-5">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto capitalize">
                    {{ isset($data) ? 'Edit' : 'Tambah' }} {{$role}}
                </h2>
                <a href="{{ route('users.index', [$role]) }}" class="btn bg-red-600 text-white px-5">
                    Kembali
                </a>
            </div>
            <form class="p-5"
                action="{{ (isset($data)) ? route('users.update', ['id' => $data->id   , 'role' => $role]) : route('users.store', [$role]) }}"
                method="POST" enctype="multipart/form-data">
                @if (isset($data))
                @method('patch')
                @endif
                @csrf
                @include('mypartials.tahunajaran')
                <div class="grid grid-cols-12 gap-x-5">
                    <div class="col-span-12 xl:col-span-6">
                        <div>
                            <label for="error"
                                class="block mb-2 text-sm font-medium @error('name') text-red-700 dark:text-red-500 @enderror">Nama
                                Lengkap</label>
                            <input type="text"
                                class="form-control @error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                placeholder="Masukan Nama" name="name"
                                value="{{ isset($data) ? $data->name : old('name') }}"
                                id="name">
                            @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-5">
                            <label for="error"
                                class="block mb-2 text-sm font-medium @error('nip') text-red-700 dark:text-red-500 @enderror">NIP</label>
                            <input type="text"
                                class="form-control @error('nip') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                placeholder="Masukan Nama" name="nip"
                                value="{{ isset($data) ? $data->nip : old('nip') }}"
                                id="nip">
                            @error('nip')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-5">
                            <label for="error"
                                class="block mb-2 text-sm font-medium @error('email') text-red-700 dark:text-red-500 @enderror">Email</label>
                            <input type="text"
                                class="form-control @error('email') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                placeholder="Masukan Nama" name="email"
                                value="{{ isset($data) ? $data->email : old('email') }}"
                                id="email">
                            @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-5">
                            <label for="error"
                                class="block mb-2 text-sm font-medium @error('password') text-red-700 dark:text-red-500 @enderror">Password</label>
                            <input type="password"
                                class="form-control @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                placeholder="Masukan Nama" name="password"
                                value="{{ isset($data) ? '' : old('password') }}"
                                id="password">
                            @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-5">
                            <label for="error"
                                class="block mb-2 text-sm font-medium @error('jk') text-red-700 dark:text-red-500 @enderror">Jenis
                                Kelamin</label>
                            <select
                                class="form-select @error('jk') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                aria-label="Default select example" name="jk" value="{{ old('jk') }}"
                                id="jk">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ isset($data) ? ($data->jk == 'L' ? 'selected' : '') :
                                    (old('jk') == 'L' ?
                                    'selected' : '') }}>Laki-laki</option>
                                <option value="P" {{ isset($data) ? ($data->jk == 'P' ? 'selected' : '') :
                                    (old('jk') == 'P' ?
                                    'selected' : '') }}>Perempuan</option>
                            </select>
                            @error('jk')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6 mt-3">
                        <label for="error"
                            class="block mb-2 text-sm font-medium @error('profil') text-red-700 dark:text-red-500 @enderror">Foto
                            Profil</label>
                        <div class="flex align-center">
                            <input type="file"
                                class="@error('profil') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                                name="profil" id="profil">
                            @if (isset($data))
                            <a href="{{ asset('storage/'.$data->profil) }}" class="btn btn-primary">Lihat</a>
                            @endif
                        </div>

                        @error('profil')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-span-12 xl:col-span-6 mt-5 flex">
                        <div class="mt-3 xl:mt-0">
                            <button type="submit" class="btn btn-primary px-5 mr-5">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
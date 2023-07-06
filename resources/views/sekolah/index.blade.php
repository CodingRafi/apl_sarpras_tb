@extends('mylayouts.main')

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-bold mr-auto">
        Sekolah
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <a href="{{ route('sekolah.create') }}">
            <button class="btn btn-primary shadow-md mr-2">
                Tambah Sekolah
            </button>
        </a>
    </div>
</div>

<div class="intro-y box p-5 mt-5">
    <div class="overflow-x-auto">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">Logo</th>
                    <th class="whitespace-nowrap">School Name</th>
                    <th class="whitespace-nowrap">NPSN</th>
                    <th class="whitespace-nowrap">Kepala Sekolah</th>
                    <th class="whitespace-nowrap">Alamat</th>
                    @if (auth()->user()->can('edit_sekolah') || auth()->user()->can('delete_sekolah'))
                    <th class="whitespace-nowrap">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($schools as $sekolah)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($sekolah->logo != '/img/tutwuri.png')
                            <img src="{{ asset('storage/' . $sekolah->logo) }}" alt=""
                                style="width: 50px;height:50px;object-fit: cover">
                            @else
                            <img src="{{ $sekolah->logo }}" alt="" style="width: 50px;height:50px;object-fit: cover">
                            @endif
                        </td>
                        <td>{{ $sekolah->nama }}</td>
                        <td>{{ $sekolah->npsn }}</td>
                        <td>{{ $sekolah->kepala_sekolah }}</td>
                        <td>{{ $sekolah->alamat }}</td>
                        @if (auth()->user()->can('edit_sekolah') || auth()->user()->can('delete_sekolah'))
                        <td>
                            <a href="{{ route('sekolah.show', $sekolah->id) }}"
                                class="btn btn-primary btn-sm rounded">Detail</a>
                            @if (auth()->user()->can('edit_sekolah'))
                            <a class="btn btn-warning btn-sm rounded"
                                href="{{ route('sekolah.edit', [$sekolah->id]) }}"
                               >Edit</a>
                            @endif
                            @if (auth()->user()->can('delete_sekolah'))
                            <button type="submit" class="btn btn-danger btn-sm rounded"
                                onclick="deleteData('{{ route('sekolah.destroy', [$sekolah->id]) }}')"
                               >Hapus</button>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

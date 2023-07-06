@extends('mylayouts.main')

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-bold mr-auto">
        Tahun Ajaran
    </h2>
    @can('add_tahun_ajaran')
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <a href="{{ route('tahun-ajaran.create') }}">
            <button class="btn btn-primary shadow-md mr-2">
                Tambah
            </button>
        </a>
    </div>
    @endcan
</div>

<div class="intro-y box p-5 mt-5">
    <div class="overflow-x-auto">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">Tahun Awal</th>
                    <th class="whitespace-nowrap">Tahun Terakhir</th>
                    <th class="whitespace-nowrap">Status</th>
                    @can('edit_tahun_ajaran')
                    <th class="whitespace-nowrap">Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($tahun_ajarans as $tahun_ajaran)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tahun_ajaran->tahun_awal }}</td>
                    <td>{{ $tahun_ajaran->tahun_akhir }}</td>
                    <td>{{ $tahun_ajaran->status }}</td>
                    <td>
                        @can('edit_tahun_ajaran')
                        <a href="{{ route('tahun-ajaran.edit', [$tahun_ajaran->id]) }}"
                            class="btn btn-sm btn-warning text-white px-3">Edit</a>
                        @endcan
                        @can('delete_tahun_ajaran')
                        <button type="submit" class="btn btn-danger btn-sm rounded"
                            onclick="deleteData('{{ route('tahun-ajaran.destroy', [$tahun_ajaran->id]) }}')">Hapus</button>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-5">
    {{ $tahun_ajarans->links() }}
</div>
@endsection
@extends('myLayouts.main')

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-Medium mr-auto">
        Peminjaman
    </h2>
    @can('edit_peminjaman')
    <a href="{{ route('peminjamans.edit', $data->id) }}">Edit</a>
    @endcan
</div>

@endsection

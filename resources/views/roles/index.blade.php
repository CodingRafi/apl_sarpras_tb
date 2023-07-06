@extends('mylayouts.main')

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Roles
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        @can('add_roles')
        <div class="text-center">
            <a href="{{ route('roles.create') }}" class="btn btn-primary">Buat
                Role</a>
        </div>
        @endcan
    </div>
</div>
<div class="intro-y box p-5 mt-5">
    <div class="overflow-x-auto scrollbar-hidden">
        <div class="overflow-x-auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">No</th>
                        <th class="whitespace-nowrap">Role</th>
                        <th class="whitespace-nowrap">Hak Akses</th>
                        <th class="whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $role->name }}</td>

                        <td>
                            @forelse ($rolePermissions[$key] as $rolePermission)
                            {{ str_replace("_", " ", $rolePermission->name) }} <br>
                            @empty
                            -- Tidak ada hak akses --
                            @endforelse
                        </td>
                        <td><a href="{{ route('roles.edit', $role->id) }}"
                                class="btn btn-warning text-white w-12">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
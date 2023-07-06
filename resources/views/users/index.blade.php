@extends('mylayouts.main')

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-bold mr-auto">
        Data {{ $role }}
    </h2>
    <div class="w-full sm:w-auto flex sm:mt-0 gap-3 ">
        @if (auth()->user()->can('export_users'))
        <x-ButtonCustom class="btn btn-primary btn-export" route="/export/users/{{ $role }}">
            Export
        </x-ButtonCustom>
        @endif
        @if (auth()->user()->can('import_users'))
        <x-ButtonCustom class="btn btn-primary" route="/import/users/{{ $role }}">
            Import
        </x-ButtonCustom>
        @endif
        @if (auth()->user()->can('add_users'))
        <x-ButtonCustom class="btn btn-primary" route="{{ route('users.create', [$role]) }}">
            Tambah
        </x-ButtonCustom>
        @endif
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="intro-y box p-5 mt-5">
            <div class="row container-filter">
                <div class="col-md-6 mb-3 mt-3">
                    <input type="text" class="form-control" placeholder="Search..." name="search"
                        onkeyup="filter_user()">
                </div>
            </div>
            <div class="table table-responsive table-hover text-center">
                <table class="table align-middle table-user">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Profil</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>
                                <img src="{{ $user->profil == '/img/profil.png' ? asset($user->profil) : asset('storage/' . $user->profil) }}"
                                    alt="" style="width: 4rem;height: 4rem;object-fit: cover;">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td class="col-2">
                                <div class="d-flex">
                                    <form action="{{ route('users.shows', ['role' => $role, 'id' => $user->id]) }}"
                                        method="get">
                                        @include('mypartials.tahunajaran')
                                        <button class="btn btn-sm btn-primary rounded mb-2"
                                            style="width: 4rem;">Detail</button>
                                    </form>
                                    @if (auth()->user()->can('edit_users'))
                                    <form action="{{ route('users.edit', ['role' => $role, 'id' => $user->id]) }}"
                                        method="get">
                                        @include('mypartials.tahunajaran')
                                        <button class="btn btn-sm btn-warning rounded mb-2"
                                            style="width: 4rem;">Edit</button>
                                    </form>
                                    @endif
                                    @if (auth()->user()->can('delete_users'))
                                    <button type="submit" class="btn btn-sm btn-danger rounded" style="width: 4rem;"
                                        onclick="deleteData('{{ route('users.destroy', ['role' => $role, 'id' => $user->id]) }}')">Hapus</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    const search = $('.container-filter input[name="search"]');
    const kelas = $('.container-filter .filter-kelas');

    function filter_user(){
        let role = '{{ request("role") }}';
        let form = new FormData();
        form.set('search', search.val());

        $.ajax({
            type: "POST",
            url: "{{ route('users.list', request('role')) }}",
            data: form,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function (response) {
                $('.table-user tbody').empty();
                let no = 1;
                $.each(response.data, function(i,e){
                    $('.table-user tbody').append(
                        `
                        <tr>
                            <th scope="row">${no}</th>
                            <td>
                                <img src="${e.profil == '/img/profil.png' ? e.profil : '/storage/' + e.profil}"
                                alt="" style="width: 4rem;height: 4rem;object-fit: cover;">
                            </td>
                            <td>${e.name}</td>
                            <td class="col-2">
                                <div class="d-flex flex-wrap gap-2">
                                    <form action="/users/${role}/${e.id}" method="get">
                                        @include('mypartials.tahunajaran')
                                        <button class="btn btn-sm btn-primary rounded mb-2" style="width: 4rem;">Detail</button>
                                    </form>
                                    @if (auth()->user()->can('edit_users'))
                                    <form action="/users/${role}/${e.id}/edit" method="get">
                                        @include('mypartials.tahunajaran')
                                        <button class="btn btn-sm btn-warning rounded mb-2" style="width: 4rem;">Edit</button>
                                    </form>
                                    @endif
                                    @if (auth()->user()->can('delete_users'))
                                    <button type="submit" class="btn btn-sm btn-danger rounded" style="width: 4rem;" onclick="deleteData('/users/${role}/${e.id}')">Hapus</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        `
                    );

                    no++;
                })
            },
            error: function (response) {
                console.log(response)
            },
        });
    }

    $('.btn-export').attr('type', 'button').on('click', function(e){
        e.preventDefault();
        $(`
            <input type="hidden" name="search" value="${search.val()}">
            <input type="hidden" name="kelas" value="${kelas.val()}">
        `).insertBefore(this)

        $(this).parent().submit();
    })  
</script>
@endpush
@extends('myLayouts.main')

@section('content')
<h2 class="intro-y text-lg font-medium mt-5">
    Kategori
</h2>
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
    <a href="{{ route('kategori.create') }}" class="btn btn-primary shadow-md mr-2">Tambah Kategori</a>
    <div class="dropdown">
        <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
        </button>
        <div class="dropdown-menu w-40">
            <ul class="dropdown-content">
                <li>
                    <a href="" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print </a>
                </li>
                <li>
                    <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                </li>
                <li>
                    <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="hidden md:block mx-auto text-slate-500">Showing 1 to 10 of 150 entries</div>
    <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
        <div class="w-56 relative text-slate-500">
            <input type="text" class="form-control w-56 box pr-10" placeholder="Search...">
            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i> 
        </div>
    </div>
</div>
<div class="flex justify-between items-center pt-10">
  
    
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">Kode</th>
                    <th class="whitespace-nowrap">Nama</th>
                    <th class="whitespace-nowrap">Kategori</th>
                    <th class="whitespace-nowrap">Sub</th>
                    <th class="text-center whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td>{{ $data->kode }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>{{ $data->jenis }}</td>
                    <td>
                        @foreach ($data->subcategory as $sub)
                            {{ $sub->nama }},
                        @endforeach
                    </td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            <a class="flex items-center mr-3" href="{{ route('kategori.edit', $data->id) }}"> <i
                                    data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                            <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2"
                                    class="w-4 h-4 mr-1"></i> Delete </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
</div>
@endsection
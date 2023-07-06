@extends('myLayouts.main')

@push('css')
<style>
    h1 {
        text-align: center;
    }

    h2 {
        margin: 0;
    }

    .text-center {
        text-align: center;
    }

    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }

    .pl-0 {
        padding-left: 0;
    }

    .button {
        padding: 0.7rem 1.5rem;
        border: 1px solid #4361ee;
        background-color: #4361ee;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
    }

    .submit-btn {
        border: 1px solid #0e9594;
        background-color: #0e9594;
    }

    .mt-3 {
        margin-top: 2rem;
    }

    .d-none {
        display: none;
    }

    .font-normal {
        font-weight: normal;
    }

    ul.form-stepper {
        counter-reset: section;
        margin-bottom: 3rem;
    }

    ul.form-stepper .form-stepper-circle {
        position: relative;
    }

    ul.form-stepper .form-stepper-circle span {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateY(-50%) translateX(-50%);
    }

    .form-stepper-horizontal {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
    }

    ul.form-stepper>li:not(:last-of-type) {
        margin-bottom: 0.625rem;
        -webkit-transition: margin-bottom 0.4s;
        -o-transition: margin-bottom 0.4s;
        transition: margin-bottom 0.4s;
    }

    .form-stepper-horizontal>li:not(:last-of-type) {
        margin-bottom: 0 !important;
    }

    .form-stepper-horizontal li {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: start;
        -webkit-transition: 0.5s;
        transition: 0.5s;
    }

    .form-stepper-horizontal li:not(:last-child):after {
        position: relative;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        height: 1px;
        content: "";
        top: 32%;
    }

    .form-stepper-horizontal li:after {
        background-color: #dee2e6;
    }

    .form-stepper-horizontal li.form-stepper-completed:after {
        background-color: #4da3ff;
    }

    .form-stepper-horizontal li:last-child {
        flex: unset;
    }

    ul.form-stepper li a .form-stepper-circle {
        display: inline-block;
        width: 40px;
        height: 40px;
        margin-right: 0;
        line-height: 1.7rem;
        text-align: center;
        background: rgba(0, 0, 0, 0.38);
        border-radius: 50%;
    }

    .form-stepper .form-stepper-active .form-stepper-circle {
        background-color: #4361ee !important;
        color: #fff;
    }

    .form-stepper .form-stepper-active .label {
        color: #4361ee !important;
    }

    .form-stepper .form-stepper-active .form-stepper-circle:hover {
        background-color: #4361ee !important;
        color: #fff !important;
    }

    .form-stepper .form-stepper-unfinished .form-stepper-circle {
        background-color: #f8f7ff;
    }

    .form-stepper .form-stepper-completed .form-stepper-circle {
        background-color: #0e9594 !important;
        color: #fff;
    }

    .form-stepper .form-stepper-completed .label {
        color: #0e9594 !important;
    }

    .form-stepper .form-stepper-completed .form-stepper-circle:hover {
        background-color: #0e9594 !important;
        color: #fff !important;
    }

    .form-stepper .form-stepper-active span.text-muted {
        color: #fff !important;
    }

    .form-stepper .form-stepper-completed span.text-muted {
        color: #fff !important;
    }

    .form-stepper .label {
        font-size: 1rem;
        margin-top: 0.5rem;
    }

    .form-stepper a {
        cursor: default;
    }

    .select2-container {
        z-index: 99999;
    }
</style>
@endpush

@section('content')
<div class="intro-y box">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="font-medium text-base mr-auto">
            {{ isset($data) ? 'Edit' : 'Tambah' }} Ruang
        </h2>
    </div>
    <div id="vertical-form" class="p-5">
        <div class="preview">
            <section id="step-1" class="form-step">
                <form action="{{ isset($data) ? route('ruang.update', [$data->id]) : route('ruang.store') }}"
                    method="POST">
                    @csrf
                    @if (isset($data))
                    @method('patch')
                    @endif
                    <div class="mb-3">
                        <label for="crud-form-1" class="form-label">Nama Ruang</label>
                        <input id="crud-form-1" type="text" class="form-control w-full" name="name"
                            value="{{ isset($data) ? $data->name : old('nama') }}" placeholder="Nama">
                    </div>
                    <div class="mb-3">
                        <label for="crud-form-2" class="form-label">Kategori</label>
                        <select name="kategori_id" id="" class="tom-select w-full">
                            @foreach($kategoris as $kategori)
                            @if ($kategori->jenis == 'prasarana')
                            <option {{ isset($data) ? ($kategori->id == $data->kategori_id ? 'selected' : '') :'' }}
                                value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="crud-form-1" class="form-label">Luas (m²)</label>
                        <input id="crud-form-1" type="number" class="form-control w-full" name="luas"
                            value="{{ isset($data) ? $data->luas : old('luas') }}" placeholder="Luas Tahan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Registrasi</label>
                        <div class="sm:grid grid-cols-3 gap-2">
                            <div class="input-group">
                                <div id="input-group-3" class="input-group-text">No</div>
                                <input type="string" class="form-control pl-3" name="no_reg"
                                    value="{{ isset($data) ? $data->no_reg : old('no_reg') }}"
                                    placeholder="Masukkan Nomor Registrasi">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="crud-form-2" class="form-label">Ruang Bisa Dipinjam</label>
                        <input type="checkbox" name="ruang_dipinjam" class="form-check-input" {{ isset($data) ?
                            ($data->ruang_dipinjam == 1 ? 'checked' : '') : '' }}>
                    </div>
                    <div class="mt-3">
                        <label for="crud-form-2" class="form-label">Produk Bisa Dipinjam</label>
                        <input type="checkbox" name="produk_dipinjam" class="form-check-input" {{ isset($data) ?
                            ($data->produk_dipinjam == 1 ? 'checked' : '') : '' }}>
                    </div>
                    <div class="mt-3">
                        <button class="button btn-navigate-form-step" type="button" step_number="2">Selanjutnya</button>
                    </div>
                </form>
            </section>
            <section id="step-2" class="form-step d-none place-items-center">
                <div class="flex justify-between align-items-center">
                    <h2 class="font-medium text-base mr-auto">
                        Produk
                    </h2>
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#modalAddProduk"
                        class="btn btn-outline-primary">Tambah Produk</a>
                </div>
                <table id="table-produk" class="table">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Kode</td>
                            <td>Nama</td>
                            <td>Merek</td>
                            <td>Kondisi</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="mt-5 flex gap-3">
                    <button class="button btn-navigate-form-step" step_number="1">Kembali</button>
                    <a href="{{ route('ruang.index') }}" class="button submit-btn">Selesai</a>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="modalkey modal fade" id="modalAddProduk" tabindex="-1" aria-labelledby="role" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="role">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="kategori" class="form-label mt-1">Kategori</label>
                        <select name="kategori_id" class="between-input-item-select" id="kategori">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                            @if ($kategori->jenis == 'sarana')
                            <option {{ isset($data) ? ($kategori->id == $data->kategori_id ? 'selected' : '') :'' }}
                                value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="subkategori" class="form-label mt-1">Sub Kategori</label>
                        <select name="subkategori_id" class="between-input-item-select" id="subkategori">
                            <option value="">Pilih Sub Kategori</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="produk" class="form-label mt-1">Produk</label>
                        <select name="produk_id[]" id="produk" class="between-input-item-select" multiple>
                            <option value="">Pilih Produk</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    const url_update = '{{ route("ruang.update", ":id") }}'
    let id = '';
    const url_sub = '{{ route("get.sub", ":id") }}';
    const url_produk = '{{ route("produk.get", ":id") }}';
    let url_get_ruang_produk = '{{ isset($data) ? route("ruang.produk", $data->id) : route("ruang.produk", ":id") }}';
    const navigateToFormStep = (stepNumber) => {
        document.querySelectorAll(".form-step").forEach((formStepElement) => {
            formStepElement.classList.add("d-none");
        });

        document.querySelector("#step-" + stepNumber).classList.remove("d-none");
    };

    document.querySelectorAll(".btn-navigate-form-step").forEach((formNavigationBtn) => {
        formNavigationBtn.addEventListener("click", () => {
            const stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));
            if (stepNumber == 2) {
                let form = new FormData($('#step-1 form')[0]);
                $.ajax({
                    type: "POST",
                    url: $('#step-1 form').attr('action'),
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
                        id = response.data.id
                        url_get_ruang_produk = url_get_ruang_produk.replace(':id', id);
                        table_produk.ajax.url(url_get_ruang_produk);
                        $('#step-1 form').attr('action', url_update.replace(':id', id)).append('<input type="hidden" name="_method" value="patch">')
                        showAlert('Berhasil tersimpan', 'success')
                        navigateToFormStep(stepNumber);
                    },
                    error: function (response) {
                        console.log(response)
                        showAlert('Gagal simpan ruang', 'error')
                    },
                });
            }else{
                navigateToFormStep(stepNumber);
            }
        });
    });

    $('#kategori').on('change', function(){
        $.ajax({
            type: "GET",
            url: url_sub.replace(':id', $(this).val()),
            beforeSend: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function (response) {
                $('#subkategori').empty().append('<option value="">Pilih Sub Kategori</option>')
                $('#produk').empty().append('<option value="">Pilih Produk</option>').select2()
                $.each(response.datas, function (key, value) {
                    $('#subkategori').append(`<option value="${value.id}">${value.nama}</option>`)
                })
                $('#subkategori').select2()
            },
            error: function (response) {
                showAlert('Gagal get subcategory', 'error')
            },
        });
    })

    $('#subkategori').on('change', function(){
        $.ajax({
            type: "GET",
            url: url_produk.replace(':id', $(this).val()),
            beforeSend: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function (response) {
                $('#produk').empty().append('<option value="">Pilih Produk</option>')
                $.each(response.datas, function (key, value) {
                    $('#produk').append(`<option value="${value.id}">${value.nama}</option>`)
                })
                $('#produk').select2();
            },
            error: function (response) {
                showAlert('Gagal get produk', 'error')
            },
        });
    })

    $('#modalAddProduk form').on('submit', function(e){
        e.preventDefault();
        let form = new FormData($(this)[0]);
        form.set('ruang_id', id)
        $.ajax({
            type: "POST",
            url: '{{ route("ruang.tambah_produk") }}',
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
                showAlert('Berhasil ditambahkan', 'success')
                $('#kategori').val('');
                $('#subkategori').empty().append('<option value="">Pilih Sub Kategori</option>').select2();
                $('#produk').empty().append('<option value="">Pilih Produk</option>').select2();
                $('.modalkey.show').trigger('click');
                table_produk.ajax.reload();
            },
            error: function (response) {
                showAlert('Gagal ditambahkan', 'error')
            },
        })
    })

    let table_produk = $('#table-produk').DataTable({
            processing: true,
            ordering: false,
            info: false,
            ajax: {
                url: url_get_ruang_produk,
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'kode'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'merek'
                },
                {
                    data: 'kondisi'
                },
                {
                    data: 'action',
                    searchable: false,
                    sortable: false
                },
            ]
        });

    function hapus_produk(id){
        if (confirm('Apakah anda yakin?')) {
            $.ajax({
                type: "POST",
                url: '{{ route("ruang.hapus_produk") }}',
                data: {
                    'produk_id': id
                },
                dataType: "json",
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    showAlert(response.message, 'success')
                    table_produk.ajax.reload();
                },
                error: function (response) {
                    showAlert('Gagal hapus produk', 'error')
                },
            })
        }
    }
    @if (isset($data))
    table_produk.ajax.url(url_get_ruang_produk)
    table_produk.ajax.reload()
    @endif
</script>
@endpush
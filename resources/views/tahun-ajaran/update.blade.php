@extends('mylayouts.main')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Update Tahun Ajaran</h4>
        <form action="{{ route('tahun-ajaran.update', [$tahun_ajaran->id]) }}" method="POST">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="tahun_awal" class="form-label">Tahun Awal</label>
                <input type="number" min="1900" max="2099" step="1" class="form-control @error('tahun_awal') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" id="tahun_awal"
                    name="tahun_awal" value="{{ $tahun_ajaran->tahun_awal, old('tahun_awal') }}">
                @error('tahun_awal')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tahun_akhir" class="form-label">Tahun Akhir</label>
                <input type="number" min="1900" max="2099" step="1" class="form-control @error('tahun_akhir') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" id="tahun_akhir"
                    name="tahun_akhir" value="{{ $tahun_ajaran->tahun_akhir, old('tahun_akhir') }}">
                @error('tahun_awal')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3 ml-4">
                <input class="form-check-input" type="checkbox" name="status" onclick="isChecked()" {{ $tahun_ajaran->status == 'aktif' ? 'checked' : '' }}>
                <label class="form-label message">Tidak Aktif</label>
            </div>
            <button type="submit" class="btn text-white btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script>
        document.addEventListener('load', isChecked());
        function isChecked(){
            if(document.querySelector('.form-check-input').
            checked){
                document.querySelector('.message').
                textContent = 'Aktif';
            }else{
                document.querySelector('.message').
                textContent = 'Tidak Aktif';
            }
        }
    </script>
@endpush
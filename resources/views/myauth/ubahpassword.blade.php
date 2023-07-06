@extends('mylayouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
  <h4 class="text-lg font-Medium mr-auto">Ubah Password</h4>
</div>
<div class="card">
  <div class="card-body">
    <div class="intro-y box p-5 mt-5">
      <form action="{{ route('profil.reset-password') }}" method="post">
        @csrf
        @method('patch')
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control @error('email') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" id="email" placeholder="name@example.com" name="email"
            style="width: 100%; height: 7vh;" value="{{ Auth::user()->email }}">
          @error('email')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" id="password"
            name="password" placeholder="Masukan password baru" style="width: 100%; height: 7vh;">
          @error('password')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="confirm-password" class="form-label">Confirm Password</label>
          <input type="password" class="form-control @error('password_confirmation') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
            id="confirm-password" name="password_confirmation" placeholder="Konfirmasi password baru"
            style="width: 100%; height: 7vh;">
          @error('password_confirmation')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="col-span-12 xl:col-span-6 mt-5 flex">
          <div class="mt-3 xl:mt-0">
              <button type="submit" class="btn btn-primary px-5 mr-5">Submit</button>
          </div>
          <a href="{{ route('profil.edit') }}" class="btn px-5">
              Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@extends('mylayouts.guard')

@push('css')
<style>
  .card-login {
    border-radius: 13px;
  }
</style>
@endpush

@section('content')
{{-- <div class="container-fluid">
  <div class="row justify-content-center align-items-center" style="min-height: 100vh;background-color: #EBEBEB;">
    <div class="col-md-5">
      <div class="card card-login">
        <div class="card-body p-4">
          <form action="{{ route('login') }}" method="POST">
            @csrf
            <h2 class="text-center mb-3" style="color: #263238;">Sign In</h2>
            <div class="mb-3 login">
              <label for="login" class="form-label">Email/NIP</label>
              <input type="text" class="form-control w-100" id="login" name="login"
                placeholder="Masukkan Email/NIP">
            </div>
            <div class="mb-3 password">
              <label class="form-label" for="password">Password</label>
              <input type="password" id="password" class="form-control input-password" name="password"
                placeholder="&nbsp;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
            </div>
            <div class="mb-3">
              <div class="container p-0">
                <div class="row" style=" width: 100%; display: flex; justify-content: space-between;">
                  <div class="col-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="remember" name="remember">
                      <label class="form-check-label m-0" for="remember">Remember Me</label>
                    </div>
                  </div>
                  <div class="col-6 d-flex justify-content-end align-items-center">
                    <a href="forgot-password" style="font-size: 12.5px;font-weight: 700;"
                      class="text-decoration-none">Lupa
                      Password?</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="d-grid gap-2">
                <button class="btn btn-primary w-100 tombol-login" type="submit">Masuk</button>
              </div>
            </div>
          </form>
          <a href="{{ route('index') }}" class="d-flex justify-content-center mt-3"><i
              class="bi bi-arrow-left-circle mr-2"></i>
            Back to Home</a>
        </div>
      </div>
    </div>
  </div>
  <div class="text-center small">Don't have an account? <a href="#">Sign up</a></div>
</div> --}}

<div class="container sm:px-10">
  <div class="block xl:grid grid-cols-2 gap-4">
      <!-- BEGIN: Login Info -->
      <div class="hidden xl:flex flex-col min-h-screen">
          <div class="-intro-x flex items-center pt-5">
              <img alt="Midone - HTML Admin Template" class="w-12" src="dist/images/logo-tb.png">
              <h2 class="text-3xl text-white pt-2">Sarpras</h2> 
          </div>
          <div class="my-auto">
              <img alt="Midone - HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="dist/images/illustration.svg">
              <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                  A few more clicks to 
                  <br>
                  sign in to your account.
              </div>
              <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your e-commerce accounts in one place</div>
          </div>
      </div>
      <!-- END: Login Info -->
      <!-- BEGIN: Login Form -->
      <form action="{{ route('login') }}" method="POST" style="display: flex;
  justify-content: center;
  align-items: center;">
        @csrf
        <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
          <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
              <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                  Sign In
              </h2>
              <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
              <div class="intro-x mt-8">
                  <input type="text" class="intro-x login__input form-control py-3 px-4 block" name="login"
                  placeholder="Masukkan Email/NIP">
                  <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" name="password"
                  placeholder="&nbsp;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
              </div>
              <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
                  <div class="flex items-center mr-auto">
                      <input id="remember-me" type="checkbox" class="form-check-input border mr-2" name="remember">
                      <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                  </div>
                  <a href="forgot-password">Forgot Password?</a> 
              </div>
              <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                  <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Login</button>
                  {{-- <button class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Register</button> --}}
              </div>
              {{-- <div class="intro-x mt-10 xl:mt-24 text-slate-600 dark:text-slate-500 text-center xl:text-left"> By signin up, you agree to our <a class="text-primary dark:text-slate-200" href="">Terms and Conditions</a> & <a class="text-primary dark:text-slate-200" href="">Privacy Policy</a> </div> --}}
          </div>
      </div>
      <!-- END: Login Form -->
      </form>
      
  </div>
</div>
@endsection
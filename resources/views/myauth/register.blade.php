@extends('mylayouts.main')

<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<style>
  input.invalid {
    background-color: #ffdddd;
  }

  /* Hide all steps by default: */
  .tab {
    display: none;
  }

  #prevBtn {
    background-color: #bbbbbb;
    border-radius: 5px;
    font-weight: 500;
    cursor: pointer;
  }

  #nextBtn {
    background-color: #3bae9c;
    border-radius: 5px;
    font-weight: 500;
    cursor: pointer;
  }

  button:hover {
    opacity: 0.8;
  }

  .btn-check:focus+.btn,
  .btn:focus {
    box-shadow: none !important;
  }

  /* Make circles that indicate the steps of the form: */
  .step {
    height: 8px;
    width: 100%;
    margin: 0 1px;
    background-color: #3bae9c;
    border: none;
    border-radius: 1px;
    display: inline-block;
    opacity: 0.3;
  }

  .step.active {
    opacity: 1;
  }

  /* Mark the steps that are finished and valid: */
  .step.finish {
    background-color: #3bae9c;
  }
</style>

@section('content')
<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper p-0 ">
    <div class="content-wrapper d-flex align-items-center auth px-0">
      <div class="row w-100 mx-0">
        <div class="col-md-8 mx-auto">
          <div class="auth-form-light text-left py-5 px-4 px-sm-5"
            style="border-radius: 10px; box-shadow: 0px 0px 5px rgba(116, 116, 116, 0.276)">
            <h3>Daftar</h3>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />

            <form class="p-0 pt-3 m-0" action="{{ route('register.store') }}" id="regForm" method="post"
              style=" width: 100%;" enctype="multipart/form-data">
              @csrf
              <div class="row" style="text-align:left; margin: auto; margin-bottom: 30px; color: rgb(94, 94, 94)">
                <div class="col-lg-4" style="padding: 1px;">
                  <div>Step 1</div>
                  <span class="step"></span>
                </div>
                <div class="col-lg-4" style="padding: 1px;">
                  <div>Step 2</div>
                  <span class="step"></span>
                </div>
                <div class="col-lg-4" style="padding: 1px;">
                  <div>Step 3</div>
                  <span class="step"></span>
                </div>
              </div>
              <div class="tab" id="sekolah">
                <h5>Data Sekolah</h5>
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama Sekolah</label>
                  <input type="text" class="form-control @error('nama_sekolah') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror  " placeholder="Nama Sekolah" name="nama_sekolah"
                    style="border-radius: 5px; width: 100%" value="{{ old('nama_sekolah') }}" required>
                    @error('nama_sekolah')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                  <label for="npsn" class="form-label">NPSN</label>
                  <input type="number" class="form-control @error('npsn') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" placeholder="NPSN" name="npsn"
                    style="border-radius: 5px; width: 100%" value="{{ old('npsn') }}" required>
                    @error('npsn')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                  <label for="kepala_sekolah" class="form-label">Nama Kepala Sekolah</label>
                  <input type="text" class="form-control @error('kepala_sekolah') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" placeholder="Kepala Sekolah"
                    name="kepala_sekolah" style="border-radius: 5px; width: 100%" value="{{ old('kepala_sekolah') }}" required>
                    @error('kepala_sekolah')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                  <label for="jenjang" class="form-label">Jenjang</label>
                  <select name="jenjang" id="jenjang" class="text-dark form-control @error('jenjang') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                    style="border-radius: 5px;"
                    required>
                    <option value="">Pilih Jenjang</option>
                    <option value="sd" {{ old('jenjang')=='sd' ? 'selected' : '' }}>SD</option>
                    <option value="smp" {{ old('jenjang')=='smp' ? 'selected' : '' }}>SMP</option>
                    <option value="sma" {{ old('jenjang')=='sma' ? 'selected' : '' }}>SMA</option>
                    <option value="smk" {{ old('jenjang')=='smk' ? 'selected' : '' }}>SMK</option>
                  </select>
                  @error('jenjang')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="logo" class="form-label">Logo (opsional)</label>
                  <input class="form-control" type="file" id="formFile" name="logo"
                    style="border-radius: 5px;">
                </div>
                <div class="row">
                  <div class="mb-3 col-lg-6">
                    <label for="ref_provinsi_id" class="form-label">Provinsi</label>
                    <select class="between-input-item-select form-control @error('ref_provinsi_id') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" name="ref_provinsi_id" id="ref_provinsi_id">
                      <option value="">Pilih Provinsi</option>
                    </select>
                    @error('ref_provinsi_id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="mb-3 col-lg-6">
                    <label for="ref_kabupaten_id" class="form-label">Kota/Kabupaten</label>
                    <select class="between-input-item-select form-select @error('ref_kabupaten_id') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" name="ref_kabupaten_id" id="ref_kabupaten_id">
                      <option value="">Pilih Kota/Kabupaten</option>
                    </select>
                    @error('ref_kabupaten_id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3 col-lg-6">
                    <label for="ref_kecamatan_id" class="form-label">Kecamatan</label>
                    <select class="between-input-item-select form-select @error('ref_kecamatan_id') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" name="ref_kecamatan_id" id="ref_kecamatan_id">
                      <option value="">Pilih Kecamatan</option>
                    </select>
                    @error('ref_kecamatan_id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="mb-3 col-lg-6">
                    <label for="ref_kelurahan_id" class="form-label">Kelurahan</label>
                    <select class="between-input-item-select form-select @error('ref_kelurahan_id') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" name="ref_kelurahan_id" id="ref_kelurahan_id">
                      <option value="">Pilih Kelurahan</option>
                    </select>
                    @error('ref_kelurahan_id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="mb-3">
                  <label for="jalan" class="form-label">Jalan</label>
                  <input type="text" class="form-control @error('jalan') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"
                    placeholder="Masukan Jalan" name="jalan" value="{{ isset($data) ? $data->jalan : old('jalan') }}"
                    style=" font-size: 15px;" id="jalan">
                  @error('jalan')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>

              <div class="tab" id="admin" style="display: none;">
                <h5>Data user admin sekolah</h5>
                <div class="mb-3">
                  <label for="name  " class="form-label">Nama admin sekolah</label>
                  <input type="text" class="form-control @error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" placeholder="Nama" name="name"
                    style="border-radius: 5px; width: 100%" value="{{ old('name') }}" required>
                    @error('name')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control @error('email') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" placeholder="Email" name="email"
                    style="border-radius: 5px; width: 100%" value="{{ old('email') }}" required>
                    @error('email')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" placeholder="password" name="password" style="border-radius: 5px; width: 100%" required>
                  @error('password')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>

              <div class="mt-3" style="overflow:auto;">
                <div style="float:right;">
                  <button class="btn text-white" type="button" id="prevBtn" onclick="nextPrev(-1)">Sebelumnya</button>
                  <button class="btn text-white" type="button" id="nextBtn" onclick="nextPrev(1)">Selanjutnya</button>
                </div>
              </div>
            </form>
            <a href="/login" class="d-flex justify-content-center mt-3"><i class="bi bi-arrow-left-circle mr-2"></i>
              Sudah daftar? Masuk sekarang!</a>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>
@endsection

@push('js')
<script>
  var currentTab = 0; // Current tab is set to be the first tab (0)
  showTab(currentTab); // Display the current tab
  
  function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n == 0) {
      document.getElementById("prevBtn").style.display = "none";
    } else {
      document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
      document.getElementById("nextBtn").innerHTML = "Daftar";
    } else {
      document.getElementById("nextBtn").innerHTML = "Selanjutnya";
    }
    //... and run a function that will display the correct step indicator:
    fixStepIndicator(n)
  }
  
  function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form...
    if (currentTab >= x.length) {
      // ... the form gets submitted:
      document.getElementById("regForm").submit();
      return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
  }
  
  function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
      document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid; // return the valid status
  }
  
  function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
      x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class on the current step:
    x[n].className += " active";
  }
</script>
@endpush
@include('mypartials.js')
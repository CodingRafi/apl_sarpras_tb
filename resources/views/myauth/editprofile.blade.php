@extends('mylayouts.main')

@section('content')
<div class="intro-y flex items-center mt-8">
  <h2 class="text-lg font-medium mr-auto">
      Update Profile
  </h2>
</div>
<div class="grid grid-cols-12 gap-6">
  <!-- BEGIN: Profile Menu -->
  <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">
      <div class="intro-y box mt-5">
          <div class="relative flex items-center p-5">
              <div class="w-12 h-12 image-fit">
                  <img alt="Midone - HTML Admin Template" class="rounded-full" src="{{ Auth::user()->profil != '/img/profil.png' ? asset('storage/' . Auth::user()->profil) : asset('/img/profil.png') }}">
              </div>
              <div class="ml-4 mr-auto">
                  <div class="font-medium text-base">{{ Auth::user()->name }}</div>
                  <div class="text-slate-500">Isi Role Kamu Kak</div>
              </div>
              <div class="dropdown">
                  <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                  <div class="dropdown-menu w-56">
                      <ul class="dropdown-content">
                          <li>
                              <h6 class="dropdown-header">
                                  Export Options
                              </h6>
                          </li>
                          <li>
                              <hr class="dropdown-divider">
                          </li>
                          <li>
                              <a href="" class="dropdown-item"> <i data-lucide="activity" class="w-4 h-4 mr-2"></i> English </a>
                          </li>
                          <li>
                              <a href="" class="dropdown-item">
                                  <i data-lucide="box" class="w-4 h-4 mr-2"></i> Indonesia 
                                  <div class="text-xs text-white px-1 rounded-full bg-danger ml-auto">10</div>
                              </a>
                          </li>
                          <li>
                              <a href="" class="dropdown-item"> <i data-lucide="layout" class="w-4 h-4 mr-2"></i> English </a>
                          </li>
                          <li>
                              <a href="" class="dropdown-item"> <i data-lucide="sidebar" class="w-4 h-4 mr-2"></i> Indonesia </a>
                          </li>
                          <li>
                              <hr class="dropdown-divider">
                          </li>
                          <li>
                              <div class="flex p-1">
                                  <button type="button" class="btn btn-primary py-1 px-2">Settings</button>
                                  <button type="button" class="btn btn-secondary py-1 px-2 ml-auto">View Profile</button>
                              </div>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
          <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
              <a class="flex items-center text-primary font-medium" href=""> <i data-lucide="activity" class="w-4 h-4 mr-2"></i> Personal Information </a>
              <a class="flex items-center mt-5" href="{{ route('profil.ubah-password') }}"> <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Change Password </a>
          </div>
       
      </div>
  </div>
  <!-- END: Profile Menu -->
  <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
      <!-- BEGIN: Display Information -->
      <div class="intro-y box lg:mt-5">
          <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
              <h2 class="font-medium text-base mr-auto">
                  Display Information
              </h2>
          </div>
          <div class="p-5">
            <form action="{{ route('profil.update') }}" method="POST" style=" width: 100%;" enctype="multipart/form-data">
              @csrf
              @method('patch')
              <div class="flex xl:flex-row flex-col">
                <div class="flex-1 mt-6 xl:mt-0">
                  
                    <div class="grid grid-cols-2 gap-x-5">
                        <div class="col-span-12 2xl:col-span-6">
                            <div>
                                <label for="update-profile-form-1" class="form-label ">Username</label>
                                <input id="update-profile-form-1" type="text" class="form-control  @error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror"" placeholder="Input Username" name="name" value="{{ Auth::user()->name }}" >
                                @error('name')
                                <div class="invalid-feedback">
                                  {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mt-3">
                              <label for="update-profile-form-1" class="form-label">Email</label>
                              <input name="email" id="update-profile-form-1" type="email" class="form-control  @error('email') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 @enderror" placeholder="Input Email" value="{{ Auth::user()->email }}" value="{{ old('email') }}"  required>
                              @error('name')
                              <div class="invalid-feedback">
                                {{ $message }}
                              </div>
                              @enderror
                            </div>
                        </div>
                        <div class="col-span-12 2xl:col-span-6">
                        
                           
                        </div>
                        <div class="col-span-12">
                           
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-20 mt-3">Save</button>
                </div>
                <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                    <div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                        <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                            <img class="rounded-md" alt="Midone - HTML Admin Template" src="{{ Auth::user()->profil != '/img/profil.png' ? asset('storage/' . Auth::user()->profil) : asset('/img/profil.png') }}">
                        </div>
                        <div class="mx-auto cursor-pointer relative mt-5">
                            <button type="button" class="btn btn-primary w-full">Change Photo</button>
                            <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0">
                        </div>
                    </div>
                </div>
            </div> 
            </form>
              
          </div>
      </div>
      <!-- END: Display Information -->
    
  </div>
</div>


@endsection
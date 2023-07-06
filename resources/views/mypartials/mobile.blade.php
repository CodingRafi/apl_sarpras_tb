 <!-- BEGIN: Mobile Menu -->
 <div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <span class="xl:block text-white text-lg">Sarpras</span>
        </a>
        <a href="javascript:;" id="mobile-menu-toggler"> <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <ul class="border-t border-white/[0.08] py-5 hidden">
        <li>
            <a href="{{ route('dashboard') }}" class="menu menu--active {{ Request::is('dashboard*') ? 'active' : '' }}">
                <div class="menu__icon"> <i data-lucide="home"></i> </div>
                <div class="menu__title"> Dashboard</div>
            </a>
            
        </li>
        @can('view_sekolah')
        <li>
            <a href="{{ route('sekolah.index') }}" class="menu {{ Request::is('sekolah*') ? 'active' : '' }}">
                <div class="menu__icon"> <i data-lucide="box"></i> </div>
                <div class="menu__title">Sekolah</div>
            </a>
        </li>
        @endcan

      
        @if (auth()->user()->can('view_tahun_ajaran') || auth()->user()->can('view_agama') ||
        auth()->user()->can('view_kelas'))
        <li class="menu__devider my-6"></li>
        <li>
            <a href="javascript:;" class="menu">
                <div class="menu__icon"> <i data-lucide="Home"></i> </div>
                <div class="menu__title">Data Master <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
            </a>
            <ul class="">
                @can('view_tahun_ajaran')
                <li>
                    <a href="{{ route('tahun-ajaran.index') }}" class="menu {{ Request::is('data-master/tahun-ajaran*') ? 'active' : '' }}">
                        <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="menu__title"> Tahun Ajaran </div>
                    </a>
                </li>
                @endcan

                @can('view_kelas')
                <li>
                    <a href="{{ route('kelas.index') }}" class="menu {{ Request::is('data-master/kelas*') ? 'active' : '' }}">
                        <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="menu__title"> Kelas </div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif

        @if (auth()->user()->can('view_kategori') || auth()->user()->can('view_produk') ||
        auth()->user()->can('view_ruang'))
        <li class="menu__devider my-6"></li>
        <li>
            <a href="javascript:;" class="menu">
                <div class="menu__icon"> <i data-lucide="Home"></i> </div>
                <div class="menu__title">Data Inventaris <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
            </a>
            <ul class="">
                @can('view_kategori')
                <li>
                    <a href="{{ route('kategori.index') }}" class="menu {{ Request::is('data-inventaris/kategori*') ? 'active' : '' }}">
                        <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="menu__title"> Kategori </div>
                    </a>
                </li>
                @endcan

                @can('view_produk')
                <li>
                    <a href="{{ route('produk.index') }}" class="menu {{ Request::is('data-inventaris/produk*') ? 'active' : '' }}">
                        <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="menu__title"> Produk </div>
                    </a>
                </li>
                @endcan

                @can('view_ruang')
                <li>
                    <a href="{{ route('ruang.index') }}" class="menu {{ Request::is('data-inventaris/ruang*') ? 'active' : '' }}">
                        <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="menu__title"> Ruang </div>
                    </a>
                </li>
                @endcan

            </ul>
        </li>
        @endif
       
        @can('view_users')
        <li class="menu__devider my-6"></li>
        <li>
            <a href="javascript:;" class="menu">
                <div class="menu__icon"> <i data-lucide="Home"></i> </div>
                <div class="menu__title">Data User <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
            </a>
            <ul class="">
                @foreach ($roles as $role)
                <li>
                    <a href="{{ route('users.index', $role->name) }}" class="menu {{ Request::is('users/'.$role->name.'*') ? 'active' : '' }}">
                        <div class="menu__icon"> <i data-lucide="Inbox"></i> </div>
                        <div class="menu__title"> Data {{ str_replace("_", " ", $role->name) }} </div>
                    </a>
                </li>
                @endforeach
                @endcan
                
            </ul>
        </li>
        @can(['view_roles'])
        <li>
            <a href="{{ route('roles.index') }}" class="menu {{ Request::is('roles*') ? 'active' : '' }}">
                <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
                <div class="menu__title"> Roles </div>
            </a>
        </li>
        @endcan
        @can('view_peminjaman')
        <li>
          <a href="{{ route('peminjamans.index') }}" class="menu {{ Request::is('peminjamans*') ? 'active' : '' }}">
            <div class="menu__icon"><i data-lucide="home"></i></div>
            <div class="menu__title">Peminjaman</div>
          </a>
        </li>
        @endcan

        {{-- @if ( !Auth::user()->hasRole('super_admin') && (Auth::user()->sekolah->jenjang == 'smk' || Auth::user()->sekolah->jenjang == 'sma'))
        @can(['view_jurusan'])
        <li>
            <a href="{{ route('jurusan.index') }}" class="menu menu--active {{ Request::is('jurusan*') ? 'active' : '' }}"">
                <div class="menu__icon"> <i data-lucide="users"></i> </div>
                <div class="menu__title">Jurusan</div>
            </a>
            
        </li>
        @endcan
        @endif --}}
    {{-- @can(['view_kategori'])
    <li>
        <a href="{{ route('kategori.index') }}" class="menu menu--active {{ Request::is('kategori*') ? 'active' : '' }}">
            <div class="menu__icon"> <i data-lucide="box"></i> </div>
            <div class="menu__title">Kategori</div>
        </a>
    </li>
    @endcan --}}
    
    </ul>
</div>
<!-- END: Mobile Menu -->
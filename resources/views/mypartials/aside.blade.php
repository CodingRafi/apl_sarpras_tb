<!-- BEGIN: Side Menu -->
<nav class="side-nav">
  <a href="" class="intro-x flex items-center pl-5 pt-4">
    <span class="hidden xl:block text-white text-lg">Sarpras</span>
  </a>
  <div class="side-nav__devider my-6"></div>
  <ul>
    <li>
      <a href="{{ route('dashboard') }}" class="side-menu {{ Request::is('dashboard*') ? 'active' : '' }}">
        <div class="side-menu__icon"> <i data-lucide="home"></i></div>
        <div class="side-menu__title">Dashboard</div>
      </a>
    </li>

    @can('view_sekolah')
    <li>
      <a href="{{ route('sekolah.index') }}" class="side-menu {{ Request::is('sekolah*') ? 'active' : '' }}">
        <div class="side-menu__icon"> <i data-lucide="activity"></i></div>
        <div class="side-menu__title">Sekolah</div>
      </a>
    </li>
    @endcan

    @if (auth()->user()->can('view_tahun_ajaran') || auth()->user()->can('view_agama') ||
    auth()->user()->can('view_kelas') || auth()->user()->can('view_jurusan'))
    <li>
      <a href="javascript:;.html" class="side-menu ">
        <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
        <div class="side-menu__title">
          Data Master
          <div class="side-menu__sub-icon"> <i data-lucide="chevron-down"></i> </div>
        </div>
      </a>
      <ul class="side-menu__sub">
        @can('view_tahun_ajaran')
        <li>
          <a href="{{ route('tahun-ajaran.index') }}"
            class="side-menu {{ Request::is('data-master/tahun-ajaran*') ? 'active' : '' }}">
            <div class="side-menu__icon"><i data-lucide="inbox"></i></div>
            <div class="side-menu__title">Tahun Ajaran</div>
          </a>
        </li>
        @endcan

        @can('view_faq')
        <li>
          <a href="{{ route('faq.index') }}"
            class="side-menu {{ Request::is('data-master/faq*') ? 'active' : '' }}">
            <div class="side-menu__icon"><i data-lucide="inbox"></i></div>
            <div class="side-menu__title">FAQ</div>
          </a>
        </li>
        @endcan

        @can('view_kelas')
        <li>
          <a href="{{ route('kelas.index') }}"
            class="side-menu {{ Request::is('data-master/kelas*') ? 'active' : '' }}">
            <div class="side-menu__icon"><i data-lucide="inbox"></i></div>
            <div class="side-menu__title">Kelas</div>
          </a>
        </li>
        @endcan

        {{-- @if (!Auth::user()->hasRole('super_admin') && (Auth::user()->sekolah->jenjang == 'smk' ||
        Auth::user()->sekolah->jenjang == 'sma'))
        @can('view_jurusan')
        <li>
          <a href="{{ route('jurusan.index') }}"
            class="side-menu {{ Request::is('data-master/jurusan*') ? 'active' : '' }}">
            <div class="side-menu__icon"><i data-lucide="inbox"></i></div>
            <div class="side-menu__title">Jurusan</div>
          </a>
        </li>
        @endcan
        @endif --}} 
      </ul>
    </li>
    @endif

    @if (auth()->user()->can('view_kategori') || auth()->user()->can('view_produk') ||
    auth()->user()->can('view_ruang'))
    <li>
      <a href="javascript:;.html" class="side-menu ">
        <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
        <div class="side-menu__title">
          Data Inventaris
          <div class="side-menu__sub-icon"> <i data-lucide="chevron-down"></i> </div>
        </div>
      </a>
      <ul class="side-menu__sub">
        @can('view_kategori')
        <li>
          <a href="{{ route('kategori.index') }}"
            class="side-menu {{ Request::is('data-inventaris/kategori*') ? 'active' : '' }}">
            <div class="side-menu__icon"><i data-lucide="inbox"></i></div>
            <div class="side-menu__title">Kategori</div>
          </a>
        </li>
        @endcan
        @can('view_produk')
        <li>
          <a href="{{ route('produk.index') }}"
            class="side-menu {{ Request::is('data-inventaris/produk*') ? 'active' : '' }}">
            <div class="side-menu__icon"><i data-lucide="inbox"></i></div>
            <div class="side-menu__title">Produk</div>
          </a>
        </li>
        @endcan
        @can('view_ruang')
        <li>
          <a href="{{ route('ruang.index') }}"
            class="side-menu {{ Request::is('data-inventaris/ruang*') ? 'active' : '' }}">
            <div class="side-menu__icon"><i data-lucide="inbox"></i></div>
            <div class="side-menu__title">Ruang</div>
          </a>
        </li>
        @endcan
      </ul>
    </li>
    @endif


    @can('view_users')
    <li>
      <a href="javascript:;.html" class="side-menu ">
        <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
        <div class="side-menu__title">
          Data User
          <div class="side-menu__sub-icon"> <i data-lucide="chevron-down"></i> </div>
        </div>
      </a>
      <ul class="side-menu__sub">
        @foreach ($roles as $role)
        <li>
          <a href="{{ route('users.index', $role->name) }}"
            class="side-menu {{ Request::is('users/'.$role->name.'*') ? 'active' : '' }}">
            <div class="side-menu__icon"><i data-lucide="inbox"></i></div>
            <div class="side-menu__title">Data {{ str_replace("_", " ", $role->name) }}</div>
          </a>
        </li>
        @endforeach
      </ul>
    </li>
    @endcan

    @can(['view_roles'])
    <li>
      <a href="{{ route('roles.index') }}" class="side-menu {{ Request::is('roles*') ? 'active' : '' }}">
        <div class="side-menu__icon"> <i data-lucide="inbox"></i></div>
        <div class="side-menu__title">Roles</div>
      </a>
    </li>
    @endcan
    
    @can('view_peminjaman')
    <li>
      <a href="{{ route('peminjamans.index') }}" class="side-menu {{ Request::is('peminjamans*') ? 'active' : '' }}">
        <div class="side-menu__icon"><i data-lucide="home"></i></div>
        <div class="side-menu__title">Peminjaman</div>
      </a>
    </li>
    @endcan
    
  </ul>
</nav>
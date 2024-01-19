<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard') }}" class="brand-link">
    <img src="/assets/dist/img/logo.png" alt="Logo" class="brand-image img-circle">
    <span class="brand-text font-weight-light">{{ env('APP_NAME') }} </span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('pesertadidik.index') }}" class="nav-link {{ request()->routeIs('pesertadidik.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Data Peserta Didik
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview {{ request()->routeIs(['kehadiran.*', 'prestasi.*', 'catatan.*', 'kenaikan.*']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              Input Data dan Nilai
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('kehadiran.index') }}" class="nav-link {{ request()->routeIs('kehadiran.*') ? 'active' : '' }}">
                <i class="fas fa-user-check nav-icon"></i>
                <p>Input Kehadiran Siswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('prestasi.index') }}" class="nav-link {{ request()->routeIs('prestasi.*') ? 'active' : '' }}">
                <i class="fas fa-trophy nav-icon"></i>
                <p>Input Prestasi Siswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('catatan.index') }}" class="nav-link {{ request()->routeIs('catatan.*') ? 'active' : '' }}">
                <i class="fas fa-edit nav-icon"></i>
                <p>Catatan Wali Kelas</p>
              </a>
            </li>
            @if(Auth::user()->guru->kelas->first()->tingkatan_id == 1 || Auth::user()->guru->kelas->first()->tingkatan_id == 2)
            @else
            <li class="nav-item">
              <a href="{{ route('kenaikan.index') }}" class="nav-link {{ request()->routeIs('kenaikan.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Input Kenaikan Kelas</p>
              </a>
            </li>  
            @endif
          </ul>
        </li>

        <!-- Kurikulum 2013 -->

        <li class="nav-item">
          <a href="{{ route('statusnilaiguru.index') }}" class="nav-link {{ request()->routeIs('statusnilaiguru.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-check-circle"></i>
            <p>
              Cek Status Penilaian
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('hasilnilai.index') }}" class="nav-link {{ request()->routeIs('hasilnilai.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-check-square"></i>
            <p>
              Hasil Pengelolaan Nilai
            </p>
          </a>
        </li>
        {{-- <li class="nav-item">
          <a href="{{ route('prosesdeskripsisikap.index') }}" class="nav-link {{ request()->routeIs('prosesdeskripsisikap.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Proses Deskripsi Sikap
            </p>
          </a>
        </li> --}}
        <li class="nav-item">
          <a href="{{ route('leger.index') }}" class="nav-link {{ request()->routeIs('leger.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Leger Nilai Siswa
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview {{ request()->routeIs(['raportptskm.*', 'raportsemesterkm.*']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-print"></i>
            <p>
              Cetak Raport
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('raportptskm.index') }}" class=" nav-link {{ request()->routeIs('raportptskm.*') ? 'active' : '' }}">
                <i class="fas fa-print nav-icon"></i>
                <p>Raport Tengah Semester</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('raportsemesterkm.index') }}" class="nav-link {{ request()->routeIs('raportsemesterkm.*') ? 'active' : '' }}">
                <i class="fas fa-print nav-icon"></i>
                <p>Raport Semester</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- End Kurikulum 2013 -->

        <li class="nav-item bg-danger mt-2">
          <a href="{{ route('logout') }}" class="nav-link {{ request()->routeIs('ekstra.*') ? 'active' : '' }}" onclick="return confirm('Apakah anda yakin ingin keluar ?')">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Keluar / Logout
            </p>
          </a> 
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
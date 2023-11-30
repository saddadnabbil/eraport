<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard') }}" class="brand-link">
    <img src="/assets/dist/img/logo.png" alt="Logo" class="brand-image img-circle">
    <span class="brand-text font-weight-light">Aplikasi E-Raport</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('pesertadidik.index') }}" class="nav-link {{ request()->routeIs('pesertadidik.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Data Peserta Didik
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview {{ request()->routeIs(['kehadiran.index', 'prestasi.index', 'catatan.index', 'kenaikan.index']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              Input Data dan Nilai
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('kehadiran.index') }}" class="nav-link {{ request()->routeIs('kehadiran.index') ? 'active' : '' }}">
                <i class="fas fa-user-check nav-icon"></i>
                <p>Input Kehadiran Siswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('prestasi.index') }}" class="nav-link {{ request()->routeIs('prestasi.index') ? 'active' : '' }}">
                <i class="fas fa-trophy nav-icon"></i>
                <p>Input Prestasi Siswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('catatan.index') }}" class="nav-link {{ request()->routeIs('catatan.index') ? 'active' : '' }}">
                <i class="fas fa-edit nav-icon"></i>
                <p>Catatan Wali Kelas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('kenaikan.index') }}" class="nav-link {{ request()->routeIs('kenaikan.index') ? 'active' : '' }}">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Input Kenaikan Kelas</p>
              </a>
            </li> 
          </ul>
        </li>

        <!-- Kurikulum 2013 -->

        <li class="nav-item">
          <a href="{{ route('statusnilaiguru.index') }}" class="nav-link {{ request()->routeIs('statusnilaiguru.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-check-circle"></i>
            <p>
              Cek Status Penilaian
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('hasilnilai.index') }}" class="nav-link {{ request()->routeIs('hasilnilai.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-check-square"></i>
            <p>
              Hasil Pengelolaan Nilai
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('prosesdeskripsisikap.index') }}" class="nav-link {{ request()->routeIs('prosesdeskripsisikap.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Proses Deskripsi Sikap
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('leger.index') }}" class="nav-link {{ request()->routeIs('leger.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Leger Nilai Siswa
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview {{ request()->routeIs(['raportpts.index', 'raportsemester.index']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-print"></i>
            <p>
              Cetak Raport
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('raportpts.index') }}" class=" nav-link {{ request()->routeIs('raportpts.index') ? 'active' : '' }}">
                <i class="fas fa-print nav-icon"></i>
                <p>Raport Tengah Semester</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('raportsemester.index') }}" class="nav-link {{ request()->routeIs('raportsemester.index') ? 'active' : '' }}">
                <i class="fas fa-print nav-icon"></i>
                <p>Raport Semester</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- End Kurikulum 2013 -->

        <li class="nav-item bg-danger mt-2">
          <a href="{{ route('logout') }}" class="nav-link {{ request()->routeIs('ekstra.index') ? 'active' : '' }}" onclick="return confirm('Apakah anda yakin ingin keluar ?')">
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
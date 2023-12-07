<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard') }}" class="brand-link">
    <img src="{{asset('assets/dist/img/logo.png')}}" alt="Logo" class="brand-image img-circle">
    <span class="brand-text font-weight-light">{{ env('APP_NAME') }} </span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <li class="nav-header">Tools</li>
        <li class="nav-item">
          <a href="{{ route('guru.silabus.index') }}" class="nav-link {{ request()->routeIs('guru.silabus.index') ? 'active' : '' }} {{ request()->routeIs('kdk13.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              Silabus
            </p>
          </a>
        </li>

        <!-- Kurikulum 2013 -->
        <li class="nav-header">RAPORT K-2013</li>
        <li class="nav-item">
          <a href="{{ route('kdk13.index') }}" class="nav-link {{ request()->routeIs('kdk13.index') ? 'active' : '' }} {{ request()->routeIs('kdk13.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              Data Kompetensi Dasar
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview {{ request()->routeIs(['rencanapengetahuan.index', 'rencanaketerampilan.index', 'rencanaspiritual.index', 'rencanasosial.index', 'bobotnilai.index']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>
              Rencana Penilaian
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('rencanapengetahuan.index') }}" class="nav-link {{ request()->routeIs('rencanapengetahuan.index') ? 'active' : '' }} {{ request()->routeIs('kdk13.index') ? 'active' : '' }}">
                <i class="fas fa-check-circle nav-icon"></i>
                <p>Nilai Pengetahuan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('rencanaketerampilan.index') }}" class="nav-link {{ request()->routeIs('rencanaketerampilan.index') ? 'active' : '' }}">
                <i class="fas fa-check-circle nav-icon"></i>
                <p>Nilai Keterampilan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('rencanaspiritual.index') }}" class="nav-link {{ request()->routeIs('rencanaspiritual.index') ? 'active' : '' }}">
                <i class="fas fa-check-circle nav-icon"></i>
                <p>Pilih KD/Butir Spiritual </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('rencanasosial.index') }}" class="nav-link {{ request()->routeIs('rencanasosial.index') ? 'active' : '' }}">
                <i class="fas fa-check-circle nav-icon"></i>
                <p>Pilih KD/Butir Sosial </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('bobotnilai.index') }}" class="nav-link {{ request()->routeIs('bobotnilai.index') ? 'active' : '' }}">
                <i class="fas fa-check-circle nav-icon"></i>
                <p>Bobot PH PTS dan PAS </p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview {{ request()->routeIs(['nilaipengetahuan.index', 'nilaiketerampilan.index', 'nilaispiritual.index', 'nilaisosial.index', 'nilaiptspas.index', 'nilaiekstra.index']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-list-ol"></i>
            <p>
              Input Nilai
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('nilaipengetahuan.index') }}" class="nav-link {{ request()->routeIs('nilaipengetahuan.index') ? 'active' : '' }}">
                <i class="fas fa-edit nav-icon"></i>
                <p>Nilai Pengetahuan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('nilaiketerampilan.index') }}" class="nav-link {{ request()->routeIs('nilaiketerampilan.index') ? 'active' : '' }}">
                <i class="fas fa-edit nav-icon"></i>
                <p>Nilai Keterampilan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('nilaispiritual.index') }}" class="nav-link {{ request()->routeIs('nilaispiritual.index') ? 'active' : '' }}">
                <i class="fas fa-edit nav-icon"></i>
                <p>Nilai Sikap Spiritual </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('nilaisosial.index') }}" class="nav-link {{ request()->routeIs('nilaisosial.index') ? 'active' : '' }}">
                <i class="fas fa-edit nav-icon"></i>
                <p>Nilai Sikap Sosial </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('nilaiptspas.index') }}" class="nav-link {{ request()->routeIs('nilaiptspas.index') ? 'active' : '' }}">
                <i class="fas fa-edit nav-icon"></i>
                <p>Nilai PTS dan PAS </p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{ route('nilaiekstra.index') }}" class="nav-link {{ request()->routeIs('nilaiekstra.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-book-reader"></i>
            <p>
              Input Nilai Ekstrakulikuler
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview {{ request()->routeIs(['kirimnilaiakhir.index', 'nilaiterkirim.index', 'prosesdeskripsi.index']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-clipboard-check"></i>
            <p>
              Nilai Akhir Raport
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('kirimnilaiakhir.index') }}" class="nav-link {{ request()->routeIs('kirimnilaiakhir.index') ? 'active' : '' }}">
                <i class="fas fa-paper-plane nav-icon"></i>
                <p>Kirim Nilai Akhir</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('nilaiterkirim.index') }}" class="nav-link {{ request()->routeIs('nilaiterkirim.index') ? 'active' : '' }}">
                <i class="fas fa-eye nav-icon"></i>
                <p>Lihat Nilai Terkirim</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{ route('prosesdeskripsi.index') }}" class="nav-link {{ request()->routeIs('prosesdeskripsi.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Proses Deskripsi Siswa
            </p>
          </a>
        </li>

        <!-- End Kurikulum 2013 -->

        <li class="nav-item bg-danger mt-2">
          <a href="{{ route('logout') }}" class="nav-link" onclick="return confirm('Apakah anda yakin ingin keluar ?')">
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
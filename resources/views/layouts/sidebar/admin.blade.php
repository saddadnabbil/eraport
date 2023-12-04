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
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
              Data User
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('pengumuman.index') }}" class="nav-link" {{ request()->routeIs('pengumuman.index') ? 'active' : '' }}>
            <i class="nav-icon fas fa-bullhorn"></i>
            <p>
              Pengumuman
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview {{ request()->routeIs(['sekolah.index', 'guru.index', 'tapel.index', 'mapel.index', 'kelas.index', 'siswa.index', 'pembelajaran.index', 'ekstrakulikuler.index', 'tingkatan.index', 'jurusan.index', 'k13kkm.index']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-server"></i>
            <p>
              Data Master
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('sekolah.index') }}" class="nav-link {{ request()->routeIs('sekolah.index') ? 'active' : '' }}">
                <i class="fas fa-school nav-icon"></i>
                <p>Profil Sekolah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('guru.index') }}" class="nav-link {{ request()->routeIs('guru.index') ? 'active' : '' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Data Guru</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('tingkatan.index') }}" class="nav-link {{ request()->routeIs('tingkatan.index') ? 'active' : '' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Data Tingkatan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('jurusan.index') }}" class="nav-link {{ request()->routeIs('jurusan.index') ? 'active' : '' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Data Jurusan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('tapel.index') }}" class="nav-link {{ request()->routeIs('tapel.index') ? 'active' : '' }}">
                <i class="fas fa-calendar-week nav-icon"></i>
                <p>Data Tahun Pelajaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('mapel.index') }}" class="nav-link {{ request()->routeIs('mapel.index') ? 'active' : '' }}">
                <i class="fas fa-book nav-icon"></i>
                <p>Data Mata Pelajaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('k13kkm.index') }}" class="nav-link {{ request()->routeIs('k13kkm.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-greater-than-equal"></i>
                <p>
                  KKM Mapel
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->routeIs('kelas.index') ? 'active' : '' }}">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Data Kelas & Wali</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.index') ? 'active' : '' }}">
                <i class="fas fa-users nav-icon"></i>
                <p>Data Siswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('pembelajaran.index') }}" class="nav-link {{ request()->routeIs('pembelajaran.index') ? 'active' : '' }}">
                <i class="fas fa-book-open nav-icon"></i>
                <p>Data Pembelajaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('ekstrakulikuler.index') }}" class="nav-link {{ request()->routeIs('ekstrakulikuler.index') ? 'active' : '' }}">
                <i class="fas fa-book-reader nav-icon"></i>
                <p>Data Ekstrakulikuler</p>
              </a>
            </li>

          </ul>
        </li>

        <!-- Kurikulum -->
        <li class="nav-header">SETTING RAPORT</li>
        <li class="nav-item">
          <a href="{{ route('k13mapping.index') }}" class="nav-link {{ request()->routeIs('k13mapping.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-list-ol"></i>
            <p>
              Mapping Mapel
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('k13interval.index') }}" class="nav-link {{ request()->routeIs('k13interval.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              Interval Predikat
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('k13sikap.index') }}" class="nav-link {{ request()->routeIs('k13sikap.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard"></i>
            <p>
              Butir-Butir Sikap
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('k13kd.index') }}" class="nav-link {{ request()->routeIs('k13kd.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              Data Kompetensi Dasar
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('k13tglraport.index') }}" class="nav-link {{ request()->routeIs('k13tglraport.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-calendar-week"></i>
            <p>
              Input Tanggal Raport
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('k13validasi.index') }}" class="nav-link {{ request()->routeIs('k13validasi.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-check-square"></i>
            <p>
              Validasi Data
            </p>
          </a>
        </li>

        <li class="nav-header">HASIL RAPORT</li>
        <li class="nav-item has-treeview {{ request()->routeIs(['k13statuspenilaian.index', 'k13pengelolaannilai.index', 'k13nilairaport.index']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-list-ol"></i>
            <p>
              Hasil Penilaian
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('k13statuspenilaian.index') }}" class="nav-link {{ request()->routeIs('k13statuspenilaian.index') ? 'active' : '' }}">
                <i class="fas fa-check-circle nav-icon"></i>
                <p>Status Penilaian</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('k13pengelolaannilai.index') }}" class="nav-link {{ request()->routeIs('k13pengelolaannilai.index') ? 'active' : '' }}">
                <i class="fas fa-check-square nav-icon"></i>
                <p>Hasil Pengelolaan Nilai</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('k13nilairaport.index') }}" class="nav-link {{ request()->routeIs('k13nilairaport.index') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check nav-icon"></i>
                <p>Nilai Raport Semester</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{ route('rekapkehadiran.index') }}" class="nav-link {{ request()->routeIs('rekapkehadiran.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-calendar-check"></i>
            <p>
              Rekap Kehadiran Siswa
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('k13leger.index') }}" class="nav-link {{ request()->routeIs('k13leger.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Leger Nilai Siswa
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview {{ request()->routeIs(['k13raportpts.index', 'k13raportsemester.index']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-print"></i>
            <p>
              Cetak Raport
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('k13raportpts.index') }}" class="nav-link {{ request()->routeIs('k13raportpts.index') ? 'active' : '' }}">
                <i class="fas fa-print nav-icon"></i>
                <p>Raport Tengah Semester</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('k13raportsemester.index') }}" class="nav-link {{ request()->routeIs('k13raportsemester.index') ? 'active' : '' }}">
                <i class="fas fa-print nav-icon"></i>
                <p>Raport Semester</p>
              </a>
            </li>
          </ul>
        </li>

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
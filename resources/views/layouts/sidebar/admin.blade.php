<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard') }}" class="brand-link">
    <img src="{{asset('assets/dist/img/logo.png')}}" alt="Logo" class="brand-image img-circle">
    <span class="brand-text font-weight-light">
      {{ env('APP_NAME') }} 
    </span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
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
              User Data
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('pengumuman.index') }}" class="nav-link" {{ request()->routeIs('pengumuman.index') ? 'active' : '' }}>
            <i class="nav-icon fas fa-bullhorn"></i>
            <p>
              Announcement
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview {{ request()->routeIs(['sekolah.index', 'guru.index', 'tapel.index', 'mapel.index', 'kelas.index', 'siswa.index', 'pembelajaran.index', 'ekstrakulikuler.index', 'tingkatan.index', 'jurusan.index', 'kkm.index', 'admin.silabus.index']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-server"></i>
            <p>
              Master Data
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('sekolah.index') }}" class="nav-link {{ request()->routeIs('sekolah.index') ? 'active' : '' }}">
                <i class="fas fa-school nav-icon"></i>
                <p>School Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('guru.index') }}" class="nav-link {{ request()->routeIs('guru.index') ? 'active' : '' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Teachers</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('tingkatan.index') }}" class="nav-link {{ request()->routeIs('tingkatan.index') ? 'active' : '' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Level</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('jurusan.index') }}" class="nav-link {{ request()->routeIs('jurusan.index') ? 'active' : '' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Line</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('tapel.index') }}" class="nav-link {{ request()->routeIs('tapel.index') ? 'active' : '' }}">
                <i class="fas fa-calendar-week nav-icon"></i>
                <p>Academic Year</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('mapel.index') }}" class="nav-link {{ request()->routeIs('mapel.index') ? 'active' : '' }}">
                <i class="fas fa-book nav-icon"></i>
                <p>Subjects</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('kkm.index') }}" class="nav-link {{ request()->routeIs('kkm.index') ? 'active' : '' }}">
                <i class="nav-icon fas fa-greater-than-equal"></i>
                <p>
                  Minimum Criteria
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->routeIs('kelas.index') ? 'active' : '' }}">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Class & Homeroom</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.index') ? 'active' : '' }}">
                <i class="fas fa-users nav-icon"></i>
                <p>Students</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('pembelajaran.index') }}" class="nav-link {{ request()->routeIs('pembelajaran.index') ? 'active' : '' }}">
                <i class="fas fa-book-open nav-icon"></i>
                <p>Learning Data</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('ekstrakulikuler.index') }}" class="nav-link {{ request()->routeIs('ekstrakulikuler.index') ? 'active' : '' }}">
                <i class="fas fa-book-reader nav-icon"></i>
                <p>Extracurricular</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.silabus.index') }}" class="nav-link {{ request()->routeIs('admin.silabus.index') ? 'active' : '' }}">
                <i class="fas fa-book-reader nav-icon"></i>
                <p>Syllabus</p>
              </a>
            </li>

          </ul>
        </li>

        <!-- Kurikulum -->
        <li class="nav-header">SETTING REPORT</li>
        <li class="nav-item">
          <a href="{{ route('mapping.index') }}" class="nav-link {{ request()->routeIs('mapping.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-list-ol"></i>
            <p>
              Mapping Subject
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('interval.index') }}" class="nav-link {{ request()->routeIs('interval.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              Interval Predikat
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('sikap.index') }}" class="nav-link {{ request()->routeIs('sikap.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard"></i>
            <p>
              Butir-Butir Sikap
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('kd.index') }}" class="nav-link {{ request()->routeIs('kd.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              Data Kompetensi Dasar
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('tglraport.index') }}" class="nav-link {{ request()->routeIs('tglraport.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-calendar-week"></i>
            <p>
              Input Tanggal Raport
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('validasi.index') }}" class="nav-link {{ request()->routeIs('validasi.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-check-square"></i>
            <p>
              Validasi Data
            </p>
          </a>
        </li>

        <li class="nav-header">REPORT RESULTS</li>
        <li class="nav-item has-treeview {{ request()->routeIs(['raportstatuspenilaian.index', 'pengelolaannilai.index', 'nilairaport.index']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-list-ol"></i>
            <p>
              Rating result
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('raportstatuspenilaian.index') }}" class="nav-link {{ request()->routeIs('raportstatuspenilaian.index') ? 'active' : '' }}">
                <i class="fas fa-check-circle nav-icon"></i>
                <p>Assessment Status</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('pengelolaannilai.index') }}" class="nav-link {{ request()->routeIs('pengelolaannilai.index') ? 'active' : '' }}">
                <i class="fas fa-check-square nav-icon"></i>
                <p>Value Management Results</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('nilairaport.index') }}" class="nav-link {{ request()->routeIs('nilairaport.index') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check nav-icon"></i>
                <p>Semester Report Value</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{ route('rekapkehadiran.index') }}" class="nav-link {{ request()->routeIs('rekapkehadiran.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-calendar-check"></i>
            <p>
              Student Attendance
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('adminleger.index') }}" class="nav-link {{ request()->routeIs('adminleger.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Leger Student Values
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview {{ request()->routeIs(['adminraportpts.index', 'adminraportsemester.index']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-print"></i>
            <p>
              Print Report
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('adminraportpts.index') }}" class="nav-link {{ request()->routeIs('adminraportpts.index') ? 'active' : '' }}">
                <i class="fas fa-print nav-icon"></i>
                <p>Mid-Semester Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('adminraportsemester.index') }}" class="nav-link {{ request()->routeIs('adminraportsemester.index') ? 'active' : '' }}">
                <i class="fas fa-print nav-icon"></i>
                <p>Semester Report</p>
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
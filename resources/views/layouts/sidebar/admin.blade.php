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
          <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
              User Data
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('pengumuman.index') }}" class="nav-link" {{ request()->routeIs('pengumuman.*') ? 'active' : '' }}>
            <i class="nav-icon fas fa-bullhorn"></i>
            <p>
              Announcement
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview {{ request()->routeIs(['sekolah.*', 'guru.*', 'tapel.*', 'mapel.*', 'kelas.*', 'siswa.*', 'pembelajaran.*', 'ekstrakulikuler.*', 'tingkatan.*', 'jurusan.*', 'admin.silabus.*']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-server"></i>
            <p>
              Master Data
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview bg-secondary">
            <li class="nav-item">
              <a href="{{ route('sekolah.index') }}" class="nav-link {{ request()->routeIs('sekolah.*') ? 'active' : '' }}">
                <i class="fas fa-school nav-icon"></i>
                <p>School Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('tapel.index') }}" class="nav-link {{ request()->routeIs('tapel.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-week nav-icon"></i>
                <p>Academic Year</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                <i class="fas fa-users nav-icon"></i>
                <p>Students</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('guru.index') }}" class="nav-link {{ request()->routeIs('guru.*') ? 'active' : '' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Teachers</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('tingkatan.index') }}" class="nav-link {{ request()->routeIs('tingkatan.*') ? 'active' : '' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Level</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('jurusan.index') }}" class="nav-link {{ request()->routeIs('jurusan.*') ? 'active' : '' }}">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Line</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('mapel.index') }}" class="nav-link {{ request()->routeIs('mapel.*') ? 'active' : '' }}">
                <i class="fas fa-book nav-icon"></i>
                <p>Subjects</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Class & Homeroom</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('pembelajaran.index') }}" class="nav-link {{ request()->routeIs('pembelajaran.*') ? 'active' : '' }}">
                <i class="fas fa-book-open nav-icon"></i>
                <p>Learning Data</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('ekstrakulikuler.index') }}" class="nav-link {{ request()->routeIs('ekstrakulikuler.*') ? 'active' : '' }}">
                <i class="fas fa-book-reader nav-icon"></i>
                <p>Extracurricular</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.silabus.index') }}" class="nav-link {{ request()->routeIs('admin.silabus.*') ? 'active' : '' }}">
                <i class="fas fa-book-reader nav-icon"></i>
                <p>Syllabus</p>
              </a>
            </li>
          </ul>
        </li> 

        {{-- Kurikulum Merdeka --}}
          <li class="nav-header">RAPORT KM</li>

          <li class="nav-item has-treeview {{ request()->routeIs(['tglraportkm.*', 'kkmadmin.*', 'mappingkm.*', 'kehadiranadmin.*', 'prestasiadmin.*', 'catatanadmin.*', 'kenaikanadmin.*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
                Input Data
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview bg-secondary">
              <li class="nav-item">
                <a href="{{ route('kkmadmin.index') }}" class="nav-link {{ request()->routeIs('kkmadmin.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-greater-than-equal"></i>
                  <p>
                    Minimum Criteria
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('mappingkm.index') }}" class="nav-link {{ request()->routeIs('mappingkm.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-list-ol"></i>
                  <p>
                    Mapping Subject
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('kehadiranadmin.index') }}" class="nav-link {{ request()->routeIs('kehadiranadmin.*') ? 'active' : '' }}">
                  <i class="fas fa-user-check nav-icon"></i>
                  <p>Kehadiran Siswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('prestasiadmin.index') }}" class="nav-link {{ request()->routeIs('prestasiadmin.*') ? 'active' : '' }}">
                  <i class="fas fa-trophy nav-icon"></i>
                  <p>Prestasi Siswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('catatanadmin.index') }}" class="nav-link {{ request()->routeIs('catatanadmin.*') ? 'active' : '' }}">
                  <i class="fas fa-edit nav-icon"></i>
                  <p>Catatan Wali Kelas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('tglraportkm.index') }}" class="nav-link {{ request()->routeIs('tglraportkm.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-calendar-week"></i>
                  <p>
                    Tanggal Raport
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('kenaikanadmin.index') }}" class="nav-link {{ request()->routeIs('kenaikanadmin.*') ? 'active' : '' }}">
                  <i class="fas fa-layer-group nav-icon"></i>
                  <p>Kenaikan Kelas</p>
                </a>
              </li> 
            </ul>
          </li>

          <li class="nav-item has-treeview {{ request()->routeIs(['cp.*', 'rencanaformatif.*', 'rencanasumatif.*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-server"></i>
              <p>
                Rencana Penilaian
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview bg-secondary">
              <li class="nav-item">
                <a href="{{ route('cp.index') }}" class="nav-link {{ request()->routeIs('cp.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-clipboard-list"></i>
                  <p>
                    Capaian Pembelajaran
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('rencanaformatif.index') }}" class="nav-link {{ request()->routeIs('rencanaformatif.*') ? 'active' : '' }}">
                  <i class="fas fa-school nav-icon"></i>
                  <p>Formatif</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('rencanasumatif.index') }}" class="nav-link {{ request()->routeIs('rencanasumatif.*') ? 'active' : '' }}">
                  <i class="fas fa-school nav-icon"></i>
                  <p>Sumatif</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('penilaiankm.index') }}" class="nav-link {{ request()->routeIs('penilaiankm.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-list-ol"></i>
              <p>
                Penilaian
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('nilaiekstraadmin.index') }}" class="nav-link {{ request()->routeIs('nilaiekstraadmin.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book-reader"></i>
              <p>
                Nilai Ekstrakulikuler
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview {{ request()->routeIs(['kirimnilaiakhirkmadmin.*', 'nilaiterkirimkmadmin.*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-clipboard-check"></i>
              <p>
                Nilai Akhir
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview bg-secondary">
              <li class="nav-item">
                <a href="{{ route('kirimnilaiakhirkmadmin.index') }}" class="nav-link {{ request()->routeIs('kirimnilaiakhirkmadmin.*') ? 'active' : '' }}">
                  <i class="fas fa-paper-plane nav-icon"></i>
                  <p>Kirim Nilai Akhir</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('nilaiterkirimkmadmin.index') }}" class="nav-link {{ request()->routeIs('nilaiterkirimkmadmin.*') ? 'active' : '' }}">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>Lihat Nilai Terkirim</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('prosesdeskripsikmadmin.index') }}" class="nav-link {{ request()->routeIs('prosesdeskripsikmadmin.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Proses Deskripsi Siswa
              </p>
            </a>
          </li>

          {{-- Start Report Result KM --}}
          <li class="nav-header">REPORT RESULTS KM</li>
          <li class="nav-item has-treeview {{ request()->routeIs(['raportstatuspenilaiankm.*', 'pengelolaannilaikm.*', 'nilairaportkm.*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list-ol"></i>
              <p>
                Rating result
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview bg-secondary">
              <li class="nav-item">
                <a href="{{ route('raportstatuspenilaiankm.index') }}" class="nav-link {{ request()->routeIs('raportstatuspenilaiankm.*') ? 'active' : '' }}">
                  <i class="fas fa-check-circle nav-icon"></i>
                  <p>Assessment Status</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pengelolaannilaikm.index') }}" class="nav-link {{ request()->routeIs('pengelolaannilaikm.*') ? 'active' : '' }}">
                  <i class="fas fa-check-square nav-icon"></i>
                  <p>Hasil Pengelolaan Nilai</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('nilairaportkm.index') }}" class="nav-link {{ request()->routeIs('nilairaportkm.*') ? 'active' : '' }}">
                  <i class="fas fa-clipboard-check nav-icon"></i>
                  <p>Semester Report Value</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('rekapkehadiran.index') }}" class="nav-link {{ request()->routeIs('rekapkehadiran.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar-check"></i>
              <p>
                Student Attendance
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('adminlegerkm.index') }}" class="nav-link {{ request()->routeIs('adminlegerkm.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Leger Student Values
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview {{ request()->routeIs(['adminraportptskm.*', 'adminraportsemesterkm.*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Print Report
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview bg-secondary">
              <li class="nav-item">
                <a href="{{ route('adminraportptskm.index') }}" class="nav-link {{ request()->routeIs('adminraportptskm.*') ? 'active' : '' }}">
                  <i class="fas fa-print nav-icon"></i>
                  <p>Mid-Semester Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('adminraportsemesterkm.index') }}" class="nav-link {{ request()->routeIs('adminraportsemesterkm.*') ? 'active' : '' }}">
                  <i class="fas fa-print nav-icon"></i>
                  <p>Semester Report</p>
                </a>
              </li>
            </ul>
          </li>
          {{-- End Report Result KM --}}
        {{-- End Kurikulum Merdeka --}}

        {{-- Kurikulum --}}
          {{-- <li class="nav-header">SETTING REPORT</li>
          <li class="nav-item">
            <a href="{{ route('kkm.index') }}" class="nav-link {{ request()->routeIs('kkm.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-greater-than-equal"></i>
              <p>
                Minimum Criteria
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('mapping.index') }}" class="nav-link {{ request()->routeIs('mapping.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-list-ol"></i>
              <p>
                Mapping Subject
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('interval.index') }}" class="nav-link {{ request()->routeIs('interval.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Interval Predikat
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('sikap.index') }}" class="nav-link {{ request()->routeIs('sikap.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                Butir-Butir Sikap
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('kd.index') }}" class="nav-link {{ request()->routeIs('kd.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
                Data Kompetensi Dasar
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('tglraport.index') }}" class="nav-link {{ request()->routeIs('tglraport.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar-week"></i>
              <p>
                Input Tanggal Raport
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('validasi.index') }}" class="nav-link {{ request()->routeIs('validasi.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-check-square"></i>
              <p>
                Validasi Data
              </p>
            </a>
          </li>

          <li class="nav-header">REPORT RESULTS K13</li>
          <li class="nav-item has-treeview {{ request()->routeIs(['raportstatuspenilaian.*', 'pengelolaannilai.*', 'nilairaport.*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list-ol"></i>
              <p>
                Rating result
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview bg-secondary">
              <li class="nav-item">
                <a href="{{ route('raportstatuspenilaian.index') }}" class="nav-link {{ request()->routeIs('raportstatuspenilaian.*') ? 'active' : '' }}">
                  <i class="fas fa-check-circle nav-icon"></i>
                  <p>Assessment Status</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pengelolaannilai.index') }}" class="nav-link {{ request()->routeIs('pengelolaannilai.*') ? 'active' : '' }}">
                  <i class="fas fa-check-square nav-icon"></i>
                  <p>Hasil Pengelolaan Nilai</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('nilairaport.index') }}" class="nav-link {{ request()->routeIs('nilairaport.*') ? 'active' : '' }}">
                  <i class="fas fa-clipboard-check nav-icon"></i>
                  <p>Semester Report Value</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="{{ route('rekapkehadiran.index') }}" class="nav-link {{ request()->routeIs('rekapkehadiran') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar-check"></i>
              <p>
                Student Attendance
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('adminleger.index') }}" class="nav-link {{ request()->routeIs('adminleger') ? 'active' : '' }}">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Leger Student Values
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview {{ request()->routeIs(['adminraportpts', 'adminraportsemester']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Print Report
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview bg-secondary">
              <li class="nav-item">
                <a href="{{ route('adminraportpts.index') }}" class="nav-link {{ request()->routeIs('adminraportpts') ? 'active' : '' }}">
                  <i class="fas fa-print nav-icon"></i>
                  <p>Mid-Semester Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('adminraportsemester.index') }}" class="nav-link {{ request()->routeIs('adminraportsemester') ? 'active' : '' }}">
                  <i class="fas fa-print nav-icon"></i>
                  <p>Semester Report</p>
                </a>
              </li>
            </ul>
          </li> --}}
          {{-- End Report Result K13 --}}
         

          <li class="nav-item bg-danger mt-2">
            <a href="{{ route('logout') }}" class="nav-link" onclick="return confirm('Apakah anda yakin ingin keluar ?')">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Keluar / Logout
              </p>
            </a>
          </li>
        {{-- end Kurikulum --}}


      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
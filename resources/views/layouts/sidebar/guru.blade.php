<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    @php
                        if (Auth::user()->hasRole('Admin')) {
                            $dashboard = route('admin.dashboard');
                        } elseif (Auth::user()->hasRole('Teacher')) {
                            $dashboard = route('guru.dashboard');
                        } elseif (Auth::user()->hasRole('Student')) {
                            $dashboard = route('siswa.dashboard');
                        }
                    @endphp
                    <a class="sidebar-link sidebar-link" href="{{ $dashboard }}" aria-expanded="false"><i
                            data-feather="home" class="feather-icon"></i><span class="hide-menu"> Dashboard </span></a>
                </li>
                @if (Auth::user()->karyawan->unitKaryawan->unit_kode == 'G01')
                    <li class="list-divider"></li>
                    <li class="nav-small-cap">
                        <span class="hide-menu">REPORT TK</span>
                    </li>
                    @include('layouts.partials.sidebar.reportkm-tk.penilaian')
                    @if (session('cek_wali_kelas_tk') == true)
                        @include('layouts.partials.sidebar.reportkm-tk.printreport_tk')
                    @endif
                @endif

                @if (Auth::user()->karyawan->unitKaryawan->unit_kode != 'G01')
                    @include('layouts.partials.sidebar.silabus')
                    @include('layouts.partials.sidebar.timetable')

                    <li class="list-divider"></li>
                    <li class="nav-small-cap">
                        <span class="hide-menu">REPORT KM</span>
                    </li>
                    @include('layouts.partials.sidebar.reportkm.rencanapenilaian')
                    @include('layouts.partials.sidebar.reportkm.penilaian')
                    @include('layouts.partials.sidebar.reportkm.nilaiekstra')
                    @include('layouts.partials.sidebar.reportkm.nilaiakhir')
                    @include('layouts.partials.sidebar.reportkm.prosesdeskripsi')
                @endif

                <li class="list-divider"></li>
                <li class="nav-small-cap">
                    <span class="hide-menu">AUTHTENTICATION</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="{{ route('logout') }}" class="nav-link"
                        aria-expanded="false" onclick="return confirm('Apakah anda yakin ingin keluar ?')"><i
                            data-feather="log-out" class="feather-icon text-danger"></i><span
                            class="hide-menu test text-danger">Logout</span></a>
                </li>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->

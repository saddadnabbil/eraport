<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- Logo icon -->
                @if (auth()->user()->hasAnyRole(['Admin', 'Curriculum', 'Teacher', 'Student']) &&
                        auth()->user()->hasAnyPermission([
                                'admin-access',
                                'masterdata-management',
                                'homeroom-pg-kg',
                                'teacher-pg-kg',
                                'teacher-km',
                                'homeroom-km',
                            ]))
                    <li class="sidebar-item">
                        @php
                            if (Auth::user()->hasRole('Admin')) {
                                $dashboard = route('admin.dashboard');
                            } elseif (Auth::user()->hasAnyRole(['Teacher', 'Curriculum'])) {
                                $dashboard = route('guru.dashboard');
                            } elseif (Auth::user()->hasRole('Student')) {
                                $dashboard = route('siswa.dashboard');
                            }
                        @endphp
                        <a class="sidebar-link sidebar-link" href="{{ $dashboard }}" aria-expanded="false"><i
                                data-feather="home" class="feather-icon"></i><span class="hide-menu"> Dashboard
                            </span></a>
                    </li>
                    <li class="list-divider"></li>
                @endif
                @if (auth()->user()->hasAnyRole(['Admin']) &&
                        auth()->user()->hasAnyPermission(['admin-access']) &&
                        request()->is('admin/*'))
                    <li class="nav-small-cap">
                        <span class="hide-menu">User Management</span>
                    </li>
                    @include('layouts.partials.sidebar.admin.user')
                    @include('layouts.partials.sidebar.admin.karyawan')
                    <li class="list-divider"></li>
                @endif

                @if (
                    (auth()->user()->hasAnyRole(['Admin', 'Curriculum']) &&
                        (auth()->user()->hasAnyPermission(['admin-access', 'masterdata-management']) &&
                            request()->is('master-data/*'))) ||
                        request()->is('guru/dashbord'))
                    <li class="nav-small-cap">
                        <span class="hide-menu">Curriculum</span>
                    </li>
                    @include('layouts.partials.sidebar.admin.pengumuman')
                    @include('layouts.partials.sidebar.admin.masterdata')
                    <li class="list-divider"></li>
                @endif

                @if (auth()->user()->hasAnyRole(['Admin', 'Teacher', 'Curriculum']) &&
                        auth()->user()->hasAnyPermission(['admin-access', 'masterdata-management', 'homeroom-pg-kg', 'teacher-pg-kg']) &&
                        request()->is('tk/*'))
                    <li class="nav-small-cap">
                        <span class="hide-menu">REPORT TK</span>
                    </li>
                    @include('layouts.partials.sidebar.reportkm-tk.event')
                    @include('layouts.partials.sidebar.reportkm-tk.area-of-learning')
                    @include('layouts.partials.sidebar.reportkm-tk.penilaian')
                    @include('layouts.partials.sidebar.reportkm-tk.printreport_tk')
                    <li class="list-divider"></li>
                @endif

                @if (
                    (auth()->user()->hasAnyRole(['Admin', 'Teacher', 'Curriculum']) &&
                        auth()->user()->hasAnyPermission([
                                'admin-access',
                                'masterdata-management',
                                'homeroom-pg-kg',
                                'teacher-pg-kg',
                                'teacher-km',
                                'homeroom-km',
                            ]) &&
                        request()->is('km/*')) ||
                        request()->is('admin/dashbaord') ||
                        request()->is('guru/dashboard') ||
                        request()->is('siswa'))
                    <li class="nav-small-cap">
                        <span class="hide-menu">REPORT KM</span>
                    </li>
                    @if (
                        (auth()->user()->hasAnyPermission(['admin-access', 'homeroom-km']) &&
                            request()->is('km/*')) ||
                            session()->get('akses_sebagai') == 'homeroom-km')
                        @include('layouts.partials.sidebar.reportkm.inputdata')
                    @else
                        @include('layouts.partials.sidebar.reportkm.rencanapenilaian')
                        @include('layouts.partials.sidebar.reportkm.penilaian')
                        @include('layouts.partials.sidebar.reportkm.nilaiekstra')
                        @include('layouts.partials.sidebar.reportkm.nilaiakhir')
                        @include('layouts.partials.sidebar.reportkm.prosesdeskripsi')
                        <li class="list-divider"></li>
    
                        <li class="nav-small-cap">
                            <span class="hide-menu">REPORT P5BK</span>
                        </li>
                        @include('layouts.partials.sidebar.report-p5.inputdata')
                        @include('layouts.partials.sidebar.report-p5.manajemen')
                    @endif

                    <li class="list-divider"></li>
                    <li class="nav-small-cap">
                        <span class="hide-menu">REPORT RESULTS KM</span>
                    </li>
                    @if (
                        (auth()->user()->hasAnyPermission(['admin-access', 'homeroom-km']) &&
                            request()->is('km/*')) ||
                            session()->get('akses_sebagai') == 'homeroom-km')
                        @include('layouts.partials.sidebar.reportresultkm.rekapkehadiran')
                        @include('layouts.partials.sidebar.reportresultkm.leger')
                        @include('layouts.partials.sidebar.reportresultkm.printreport')
                    @else
                    @endif
                    <li class="list-divider"></li>
                @endif


                {{-- <li class="nav-small-cap">
                    <span class="hide-menu">AUTHTENTICATION</span>
                </li>
                <li class="sidebar-item">
                    <form class="sidebar-link sidebar-link" id="logout-form" action="{{ route('logout') }}"
                        method="POST" style="display: inline;">
                        @csrf
                        <button type="button" onclick="confirmLogout()"
                            class="text-decoration-none border-0 bg-transparent btn-link text-danger"> <i
                                data-feather="log-out" class="feather-icon text-danger"></i>Logout</button>
                    </form>
                </li> --}}
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

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
                            data-feather="home" class="feather-icon"></i><span class="hide-menu"> Dashboard
                        </span></a>
                </li>
                @if (auth()->user()->hasPermissionTo('admin-access') && request()->is('admin/*'))
                    @include('layouts.partials.sidebar.admin.user')
                    @include('layouts.partials.sidebar.admin.karyawan')
                    @include('layouts.partials.sidebar.admin.pengumuman')
                    @include('layouts.partials.sidebar.admin.masterdata')
                @endif

                @if (auth()->user()->hasAnyPermission(['admin-access', 'homeroom-pg-kg', 'teacher-pg-kg']) && request()->is('admin/tk/*'))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap">
                        <span class="hide-menu">REPORT TK</span>
                    </li>
                    @include('layouts.partials.sidebar.reportkm-tk.event')
                    @include('layouts.partials.sidebar.reportkm-tk.area-of-learning')
                    @include('layouts.partials.sidebar.reportkm-tk.penilaian')
                    @include('layouts.partials.sidebar.reportkm-tk.printreport_tk')
                @endif

                @if (auth()->user()->hasAnyPermission(['admin-access', 'homeroom-pg-kg', 'teacher-pg-kg']) && request()->is('admin/km/*'))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap">
                        <span class="hide-menu">REPORT KM</span>
                    </li>
                    @include('layouts.partials.sidebar.reportkm.inputdata')
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

                    <li class="list-divider"></li>
                    <li class="nav-small-cap">
                        <span class="hide-menu">REPORT RESULTS KM</span>
                    </li>
                    @include('layouts.partials.sidebar.reportresultkm.rekapkehadiran')
                    @include('layouts.partials.sidebar.reportresultkm.leger')
                    @include('layouts.partials.sidebar.reportresultkm.printreport')
                @endif


                <li class="list-divider"></li>
                <li class="nav-small-cap">
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
                </li>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

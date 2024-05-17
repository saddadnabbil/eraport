<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- Logo icon -->
                @php
                    $user = Auth::user();
                @endphp
                @hasanyrole(['Admin', 'Curriculum', 'Teacher', 'Student'])
                    @canany(['admin-access', 'teacher-km', 'homeroom-km', 'masterdata-management', 'homeroom-pg-kg',
                        'teacher-pg-kg', 'student-access'])
                        @php
                            if ($user->hasRole('Admin')) {
                                $dashboard = route('admin.dashboard');
                            } elseif ($user->hasAnyRole(['Teacher', 'Curriculum'])) {
                                $dashboard = route('guru.dashboard');
                            } elseif ($user->hasRole('Student')) {
                                $dashboard = route('siswa.dashboard');
                            }
                        @endphp
                        <li class="sidebar-item">
                            <a class="sidebar-link sidebar-link" href="{{ $dashboard }}" aria-expanded="false"><i
                                    data-feather="home" class="feather-icon"></i><span class="hide-menu"> Dashboard
                                </span></a>
                        </li>
                        <li class="list-divider"></li>
                    @endcanany
                    @canany(['teacher-km', 'student-access'])
                        @if (session()->get('akses_sebagai') != 'homeroom-km' &&
                                session()->get('akses_sebagai') != 'teacher-pg-kg' &&
                                !auth()->user()->can('admin-access'))
                            @include('layouts.partials.sidebar.silabus')
                            @include('layouts.partials.sidebar.timetable')
                            <li class="list-divider"></li>
                        @endif
                    @endcan
                @endhasanyrole

                @hasanyrole(['Admin'])
                    @canany(['admin-access'])
                        @if (request()->is('admin/*'))
                            <li class="nav-small-cap">
                                <span class="hide-menu">User Management</span>
                            </li>
                            @include('layouts.partials.sidebar.admin.user')
                            @include('layouts.partials.sidebar.admin.karyawan')
                            <li class="list-divider"></li>
                        @endif
                    @endcanany
                @endhasanyrole

                @hasanyrole(['Admin', 'Teacher', 'Curriculum'])
                    @canany(['admin-access', 'masterdata-management'])
                        @if (request()->is('master-data/*') || request()->is('guru/dashbord'))
                            <li class="nav-small-cap">
                                <span class="hide-menu">Curriculum</span>
                            </li>
                            @include('layouts.partials.sidebar.admin.pengumuman')
                            @include('layouts.partials.sidebar.admin.masterdata')
                            <li class="list-divider"></li>
                        @endif
                    @endcanany
                @endhasanyrole

                @hasanyrole(['Admin', 'Teacher', 'Curriculum'])
                    @canany(['admin-access', 'masterdata-management', 'homeroom-pg-kg', 'teacher-pg-kg'])
                        @if (request()->is('tk/*') || request()->is('guru/dashbord'))
                            <li class="nav-small-cap">
                                <span class="hide-menu">REPORT TK</span>
                            </li>
                            @canany(['masterdata-management'])
                                @include('layouts.partials.sidebar.reportkm-tk.event')
                                @include('layouts.partials.sidebar.reportkm-tk.area-of-learning')
                            @endcanany
                            @canany(['teacher-pg-kg'])
                                @include('layouts.partials.sidebar.reportkm-tk.penilaian')
                            @endcanany
                            @canany(['homeroom-pg-kg'])
                                @include('layouts.partials.sidebar.reportkm-tk.printreport_tk')
                            @endcanany
                            <li class="list-divider"></li>
                        @endif
                    @endcan
                @endhasanyrole
                @dd($user->getPermissionNames())
                @role(['Admin', 'Teacher', 'Curriculum'])
                    @can(['admin-access', 'masterdata-management', 'teacher-km', 'homeroom-km'])
                        @if (request()->is('km/*') ||
                                request()->is('guru/dashboard') ||
                                request()->is('siswa') ||
                                request()->is('master-data/silabus'))
                            <li class="nav-small-cap">
                                <span class="hide-menu">REPORT KM</span>
                            </li>
                            @dd('mantul')
                            @can(['admin-access', 'homeroom-km'])
                                @if (session()->get('akses_sebagai') != 'homeroom-km' && session()->get('akses_sebagai') != 'teacher-km')
                                    @include('layouts.partials.sidebar.reportkm.inputdata')
                                    @include('layouts.partials.sidebar.reportkm.rencanapenilaian')
                                    @include('layouts.partials.sidebar.reportkm.penilaian')
                                    @include('layouts.partials.sidebar.reportkm.nilaiekstra')
                                    @include('layouts.partials.sidebar.reportkm.nilaiakhir')
                                    @include('layouts.partials.sidebar.reportkm.prosesdeskripsi')
                                @elseif (session()->get('akses_sebagai') == 'homeroom-km' || session()->get('akses_sebagai') != 'teacher-km')
                                    @include('layouts.partials.sidebar.reportkm.inputdata')
                                @elseif (
                                    (request()->is('guru/dashboard') && session()->get('akses_sebagai') == 'teacher-km') ||
                                        session()->get('akses_sebagai') == 'teacher-km' ||
                                        request()->is('admin/dashboard'))
                                    @include('layouts.partials.sidebar.reportkm.rencanapenilaian')
                                    @include('layouts.partials.sidebar.reportkm.penilaian')
                                    @include('layouts.partials.sidebar.reportkm.nilaiekstra')
                                    @include('layouts.partials.sidebar.reportkm.nilaiakhir')
                                    @include('layouts.partials.sidebar.reportkm.prosesdeskripsi')
                                @endif
                            @endcan

                            @hasanyrole(['Admin', 'Teacher', 'Curriculum'])
                                @canany(['admin-access', 'masterdata-management', 'teacher-km'])
                                    @if (session()->get('akses_sebagai') != 'teacher-km' && session()->get('akses_sebagai') != 'homeroom-km')
                                        <li class="list-divider"></li>
                                        <li class="nav-small-cap">
                                            <span class="hide-menu">REPORT P5BK</span>
                                        </li>
                                        @include('layouts.partials.sidebar.report-p5.inputdata')
                                        @include('layouts.partials.sidebar.report-p5.manajemen')
                                    @elseif (request()->is('master-data/*') && session()->get('akses_sebagai') != 'homeroom-km')
                                        <li class="list-divider"></li>
                                        <li class="nav-small-cap">
                                            <span class="hide-menu">REPORT P5BK</span>
                                        </li>
                                        @include('layouts.partials.sidebar.report-p5.inputdata')
                                    @elseif (session()->get('akses_sebagai') == 'teacher-km')
                                        <li class="list-divider"></li>
                                        <li class="nav-small-cap">
                                            <span class="hide-menu">REPORT P5BK</span>
                                        </li>
                                        @include('layouts.partials.sidebar.report-p5.manajemen')
                                    @endif
                                @endcanany
                            @endhasanyrole

                            @canany(['admin-access', 'homeroom-km'])
                                @if (session()->get('akses_sebagai') == 'teacher-km')
                                @else
                                    <li class="list-divider"></li>
                                    <li class="nav-small-cap">
                                        <span class="hide-menu">REPORT RESULTS KM</span>
                                    </li>
                                    <ul>
                                        @include('layouts.partials.sidebar.reportresultkm.rekapkehadiran')
                                        @include('layouts.partials.sidebar.reportresultkm.leger')
                                        @include('layouts.partials.sidebar.reportresultkm.printreport')
                                    </ul>
                                @endif
                            @endcanany

                            <li class="list-divider"></li>
                        @endif
                    @endcanany
                @endrole

                @hasanyrole(['Student'])
                    @canany(['student-access'])
                        @include('layouts.partials.sidebar.ekstra')
                        @include('layouts.partials.sidebar.reportresultkm.rekapkehadiran')
                        @include('layouts.partials.sidebar.reportresultkm.leger')
                    @endcanany
                @endhasanyrole

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

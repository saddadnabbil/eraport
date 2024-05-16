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
                    @endcanany
                    @if (
                        (session()->get('akses_sebagai') != 'homeroom-km' && !$user->hasRole('Admin')) ||
                            !auth()->user()->can('admin-access'))
                        @canany(['teacher-km', 'student-access'])
                            @include('layouts.partials.sidebar.silabus')
                        @endcan
                        <li class="list-divider"></li>
                    @endif
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
                        @if (request()->is('tk/*'))
                            <li class="nav-small-cap">
                                <span class="hide-menu">REPORT TK</span>
                            </li>
                            @include('layouts.partials.sidebar.reportkm-tk.event')
                            @include('layouts.partials.sidebar.reportkm-tk.area-of-learning')
                            @include('layouts.partials.sidebar.reportkm-tk.penilaian')
                            @include('layouts.partials.sidebar.reportkm-tk.printreport_tk')
                            <li class="list-divider"></li>
                        @endif
                    @endcan
                @endhasanyrole

                @hasanyrole(['Admin', 'Teacher', 'Curriculum'])
                    @canany(['admin-access', 'masterdata-management', 'homeroom-pg-kg', 'teacher-pg-kg', 'teacher-km',
                        'homeroom-km'])
                        @if (request()->is('km/*') ||
                                request()->is('admin/dashbaord') ||
                                request()->is('guru/dashboard') ||
                                request()->is('siswa') ||
                                request()->is('master-data/silabus'))
                            <li class="nav-small-cap">
                                <span class="hide-menu">REPORT KM</span>
                            </li>
                            @canany(['admin-access', 'homeroom-km'])
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
                            @endcanany

                            @hasanyrole(['Admin', 'Teacher', 'Curriculum'])
                                @canany(['admin-access', 'masterdata-management', 'teacher-km'])
                                    @if (session()->get('akses_sebagai') != 'teacher-km' && session()->get('akses_sebagai') != 'homeroom-km')
                                        <li class="list-divider"></li>
                                        <li class="nav-small-cap">
                                            <span class="hide-menu">REPORT P5BK</span>
                                        </li>
                                        @include('layouts.partials.sidebar.report-p5.inputdata')
                                        @include('layouts.partials.sidebar.report-p5.manajemen')
                                    @elseif (request()->is('master-data/*'))
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
                @endhasanyrole

                @hasanyrole(['Student'])
                    @canany(['student-access'])
                        @include('layouts.partials.sidebar.ekstra')
                        @include('layouts.partials.sidebar.reportresultkm.rekapkehadiran')
                        @include('layouts.partials.sidebar.timetable')
                        @include('layouts.partials.sidebar.reportresultkm.leger')
                    @endcanany
                @endhasanyrole
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

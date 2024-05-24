<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- Logo icon -->
                @php
                    $user = Auth::user();
                    if (Auth::user()->hasRole('Admin')) {
                        $dashboard = route('admin.dashboard');
                    } elseif (
                        (Auth::user()->hasRole('Curriculum') && !Auth::user()->hasRole('Teacher')) ||
                        request()->is('teacher/master-data/*') ||
                        request()->is('curriculum/dashboard')
                    ) {
                        $dashboard = route('curriculum.dashboard');
                    } elseif (
                        Auth::user()->hasAnyRole(['Teacher', 'Teacher PG-KG', 'Co-Teacher', 'Co-Teacher PG-KG'])
                    ) {
                        $dashboard = route('guru.dashboard');
                    } elseif (Auth::user()->hasRole('Student')) {
                        $dashboard = route('siswa.dashboard');
                    }
                @endphp
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="{{ $dashboard }}" aria-expanded="false"><i
                            data-feather="home" class="feather-icon"></i><span class="hide-menu"> Dashboard
                        </span></a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="{{ route('guru.silabus.index') }}" aria-expanded="false"><i
                            data-feather="home" class="feather-icon"></i><span class="hide-menu"> Syllabus
                        </span></a>
                </li>
                <li class="list-divider"></li>



                @if ($user->hasRole('Curriculum'))
                    @if (request()->is('teacher/master-data/*') || request()->is('curriculum/dashboard'))
                        <li class="nav-small-cap">
                            <span class="hide-menu">Curriculum</span>
                        </li>
                        @include('layouts.partials.sidebar.guru.pengumuman')
                        @include('layouts.partials.sidebar.guru.masterdata')
                        <li class="list-divider"></li>
                    @endif

                    @if (request()->is('teacher/km/p5*'))
                        <li class="list-divider"></li>
                        <li class="nav-small-cap">
                            <span class="hide-menu">REPORT P5BK</span>
                        </li>
                        @include('layouts.partials.sidebar.report-p5.inputdata')
                    @endif
                @endif

                @if ($user->hasRole('Teacher PG-KG'))
                    @if ((request()->is('teacher/tk/*') || request()->is('teacher/dashboard')) && session('akses_sebagai') != 'teacher-km')
                        <li class="nav-small-cap">
                            <span class="hide-menu">REPORT TK</span>
                        </li>
                        @include('layouts.partials.sidebar.reportkm-tk.event')
                        @include('layouts.partials.sidebar.reportkm-tk.area-of-learning')
                        @include('layouts.partials.sidebar.reportkm-tk.penilaian')
                        @include('layouts.partials.sidebar.reportkm-tk.printreport_tk')
                        <li class="list-divider"></li>
                    @endif
                @endif

                @if ($user->hasRole('Teacher'))
                    @if (request()->is('teacher/km/*') || request()->is('teacher/dashboard'))
                        <li class="nav-small-cap">
                            <span class="hide-menu">REPORT KM</span>
                        </li>
                        @include('layouts.partials.sidebar.reportkm.rencanapenilaian')
                        @include('layouts.partials.sidebar.reportkm.penilaian')
                        @include('layouts.partials.sidebar.reportkm.nilaiekstra')
                        @include('layouts.partials.sidebar.reportkm.nilaiakhir')
                        @include('layouts.partials.sidebar.reportkm.prosesdeskripsi')

                        <li class="list-divider"></li>
                        <li class="nav-small-cap">
                            <span class="hide-menu">REPORT P5BK</span>
                        </li>
                        @include('layouts.partials.sidebar.report-p5.manajemen')

                        <li class="list-divider"></li>
                    @endif
                @endif

                <li class="nav-small-cap">
                    <span class="hide-menu">AUTHTENTICATION</span>
                </li>
                <li class="sidebar-item">
                    <button type="button" id="logout-form" onclick="confirmLogout()"
                        class="text-decoration-none border-0 bg-transparent btn-link text-danger button sidebar-link sidebar-link"
                        style="display: inline;"> <i data-feather="log-out"
                            class="feather-icon text-danger"></i>Logout</button>
                </li>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

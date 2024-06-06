<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-lg">
        <div class="navbar-header" data-logobg="skin6">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-brand">
                <!-- Logo icon -->
                @php
                    if ($user->hasRole(['Admin'])) {
                        $dashboard = route('admin.dashboard');
                        $tapel = route('admin.tapel.index');
                    } elseif ($user->hasRole(['Curriculum'])) {
                        $dashboard = route('curriculum.dashboard');
                        $tapel = route('guru.tapel.index');
                    } elseif ($user->hasAnyRole(['Teacher', 'Teacher PG-KG', 'Teacher'])) {
                        $dashboard = route('guru.dashboard');
                    } elseif ($user->hasRole('Student')) {
                        $dashboard = route('siswa.dashboard');
                    }
                @endphp
                <a href="{{ $dashboard }}">
                    <img src="{{ asset('assets/images/logo-gis.png') }}" alt="" class="img-fluid" />
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                    class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse " id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left me-auto ms-3 ps-1">
                @if (
                    $user->hasAnyRole(['Teacher', 'Co-Teacher']) &&
                        !request()->is('teacher/master-data/*') &&
                        !request()->is('curriculum/dashboard'))
                    <div style="padding: 0 15px; margin-left: 1rem;">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link" href="javascript:void(0)">
                                <div class="customize-input">
                                    <select id="roleSelect"
                                        class="custom-select form-control bg-white custom-radius custom-shadow border-0">
                                        <option value="1" @if (session()->get('akses_sebagai') == 'teacher-km' && session()->get('cek_homeroom') == true) selected @endif><a
                                                class="dropdown-item" href="{{ route('ganti-akses') }}">
                                                @if (session()->get('akses_sebagai') == 'teacher-km' && session()->get('cek_homeroom') == true)
                                                    Teacher
                                                @else
                                                    Change
                                                    to Teacher
                                                @endif
                                            </a></option>
                                        <option value="2" @if (session()->get('akses_sebagai') == 'homeroom-km') selected @endif>
                                            <a class="dropdown-item" href="{{ route('ganti-akses') }}">
                                                @if (session()->get('akses_sebagai') == 'homeroom-km')
                                                    Homeroom
                                                @else
                                                    Change
                                                    to Homeroom
                                                @endif
                                            </a>
                                        </option>
                                    </select>
                                </div>
                            </a>
                        </li>
                    </div>
                @endif

                <div class="d-flex align-items-center justify-content-center"
                    style="padding: 0 15px; margin-left: 1rem;">
                    <li class="nav-item d-none d-md-block">
                        <a href="{{ $user->hasAnyRole(['Admin', 'Curriculum']) ? $tapel : 'javascript:void(0)' }}"
                            style="line-height: 1">
                            <div class="customize-input">
                                <span class="badge bg-success">
                                    @php
                                        $tapel = App\Models\Tapel::where('status', 1)->first();
                                        $term = App\Models\Term::find($tapel->term_id);

                                        $pg = App\Models\Tingkatan::where('id', 1)->first();
                                        $kg = App\Models\Tingkatan::where('id', 2)->first();
                                        $ps = App\Models\Tingkatan::where('id', 3)->first();
                                        $jhs = App\Models\Tingkatan::where('id', 4)->first();
                                        $shs = App\Models\Tingkatan::where('id', 5)->first();
                                    @endphp

                                    @php
                                        $tapel = App\Models\Tapel::where('status', 1)->first();
                                        $term = App\Models\Term::find($tapel->term_id);

                                        $pg_kg = App\Models\Tingkatan::whereIn('id', [1, 2, 3])->first();
                                        $pg = App\Models\Tingkatan::where('id', 1)->first();
                                        $kg = App\Models\Tingkatan::where('id', 2)->first();
                                        $ps = App\Models\Tingkatan::where('id', 4)->first();
                                        $jhs = App\Models\Tingkatan::where('id', 5)->first();
                                        $shs = App\Models\Tingkatan::where('id', 6)->first();
                                    @endphp

                                    @if (optional($pg)->count() > 0 &&
                                            optional($kg)->count() > 0 &&
                                            optional($pg_kg)->count() > 0 &&
                                            optional($ps)->count() > 0 &&
                                            optional($jhs)->count() > 0 &&
                                            optional($shs)->count() > 0)
                                        School Year {{ str_replace('-', ' / ', $tapel->tahun_pelajaran) }} -
                                        (Term PG/KG - {{ optional($pg_kg)->term_id }}) -
                                        (Semester PS
                                        {{ optional($ps)->semester_id . '-' . optional($ps)->term_id }}) -
                                        (Semester JHS
                                        {{ optional($jhs)->semester_id . '-' . optional($jhs)->term_id }}) -
                                        (Semester SHS
                                        {{ optional($shs)->semester_id . '-' . optional($shs)->term_id }}) - Term
                                        {{ $term->id }}
                                    @else
                                        No Levels Found
                                    @endif
                                </span>
                            </div>
                        </a>
                    </li>
                </div>
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            {{-- role looping --}}

            <ul class="navbar-nav float-end">
                @if (
                    $user->hasAnyPermission([
                        'admin-access',
                        'masterdata-management',
                        'homeroom-km',
                        'homeroom-pg-kg',
                        'teacher-km',
                        'teacher-pg-kg',
                    ]))

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                            id="bell" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">
                            <span><i data-feather="grid" class="svg-icon"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-center mailbox animated bounceInDown">
                            <ul class="list-style-none">
                                <li>
                                    <div class="message-center notifications position-relative">
                                        @if ($user->hasRole('Admin'))
                                            <a href="{{ request()->is('admin/dashboard') || request()->is('admin/user/*') ? 'javascript:void(0)' : route('admin.dashboard') }}"
                                                @if (request()->is('admin/dashboard/*') || request()->is('admin/user/*')) disabled style="background: #e8eaec;" @endif
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <div class="btn btn-danger rounded-circle btn-circle"><i
                                                        data-feather="airplay" class="text-white"></i></div>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1 text-nowrap">Admin</h6>
                                                </div>
                                            </a>

                                            <a href="{{ request()->is('admin/master-data/*') ? 'javascript:void(0)' : route('admin.sekolah.index') }}"
                                                @if (request()->is('admin/master-data/*')) disabled style="background: #e8eaec;" @endif
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <div class="btn btn-danger rounded-circle btn-circle"><i
                                                        data-feather="airplay" class="text-white"></i></div>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1 text-nowrap">Curriculum</h6>
                                                </div>
                                            </a>

                                            <a href="{{ request()->is('admin/tk/*') ? 'javascript:void(0)' : route('tk.event.index') }}"
                                                @if (request()->is('admin/tk/*')) disabled style="background: #e8eaec;" @endif
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <div class="btn btn-danger rounded-circle btn-circle"><i
                                                        data-feather="airplay" class="text-white"></i></div>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1 text-nowrap">Report TK</h6>
                                                </div>
                                            </a>

                                            <a href="{{ request()->is('admin/km/*') ? 'javascript:void(0)' : route('km.kkm.index') }}"
                                                @if (request()->is('admin/km/*')) disabled style="background: #e8eaec;" @endif
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <div class="btn btn-danger rounded-circle btn-circle"><i
                                                        data-feather="airplay" class="text-white"></i></div>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1 text-nowrap">Raport KM</h6>
                                                </div>
                                            </a>
                                        @endif

                                        @if ($user->hasRole('Curriculum'))
                                            <a href="{{ request()->is('teacher/master-data/*') || request()->routeIs('curriculum.dashboard') ? 'javascript:void(0)' : route('curriculum.dashboard') }}"
                                                @if (request()->is('teacher/master-data/*') || request()->routeIs('curriculum.dashboard')) disabled style="background: #e8eaec;" @endif
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <div class="btn btn-danger rounded-circle btn-circle"><i
                                                        data-feather="airplay" class="text-white"></i></div>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1 text-nowrap">Curriculum</h6>
                                                </div>
                                            </a>
                                        @endif

                                        @if ($user->hasRole('Teacher PG-KG'))
                                            <a href="{{ route('guru.tk.penilaian.index') }}"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <div class="btn btn-danger rounded-circle btn-circle"><i
                                                        data-feather="airplay" class="text-white"></i></div>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1 text-nowrap">Report TK</h6>
                                                </div>
                                            </a>
                                        @endif

                                        @if ($user->hasRole('Teacher'))
                                            <a href="{{ route('guru.dashboard') }}"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <div class="btn btn-danger rounded-circle btn-circle"><i
                                                        data-feather="airplay" class="text-white"></i></div>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1 text-nowrap">Raport KM</h6>
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav float-end">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('assets/dist/img/avatar/default.png') }}" alt="user"
                            class="rounded-circle" width="40" />
                        <span class="ms-2 d-none d-lg-inline-block"><span>Hello,</span>
                            <span class="text-dark">
                                @if ($user->hasRole('Admin'))
                                    {{ $user->karyawan->nama_lengkap }}
                                @elseif ($user->hasAnyRole(['Teacher', 'Teacher PG-KG', 'Co-Teacher', 'Co-Teacher PG-KG', 'Curriculum']))
                                    {{ $user->karyawan->nama_lengkap }}
                                @elseif($user->hasRole('Student'))
                                    {{ $user->siswa->nama_lengkap }}
                                @endif
                            </span>
                            <i data-feather="chevron-down" class="svg-icon"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                        <a class="dropdown-item" href="{{ route('profile') }}"><i data-feather="user"
                                class="svg-icon me-2 ms-1"></i> My Profile</a>
                        <a class="dropdown-item" href="{{ route('gantipassword') }}"><i data-feather="settings"
                                class="svg-icon me-2 ms-1"></i>Change Password</a>

                        @if ($user->hasRole('Teacher'))
                            @if (session()->get('akses_sebagai') == 'teacher-km')
                                <a class="dropdown-item" href="{{ route('ganti-akses') }}"><i
                                        data-feather="toggle-right" class="svg-icon me-2 ms-1"></i> Change to
                                    Homeroom</a>
                            @elseif (session()->get('akses_sebagai') == 'teacher-km')
                                <a class="dropdown-item" href="{{ route('ganti-akses') }}"><i
                                        data-feather="toggle-left" class="svg-icon me-2 ms-1"></i> Change to
                                    Teacher</a>
                            @endif
                        @endif
                        <div class="dropdown-divider"></div>

                        <form class="dropdown-item text-danger text-center" id="logout-form"
                            action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="button" onclick="confirmLogout()"
                                class="text-decoration-none border-0 bg-transparent btn-link text-danger"><i
                                    data-feather="log-out"
                                    class="svg-icon me-2 ms-1 feather-icon text-danger"></i>Logout</button>
                        </form>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>

@if (
    ($user->hasRole(['Teacher']) && request()->is('teacher/km/*')) ||
        (request()->is('teacher/dashboard') && session()->get('akses_sebagai') == 'homeroom-km') ||
        session()->get('akses_sebagai') == 'teacher-km')
    <script>
        document.getElementById('roleSelect').addEventListener('change', function() {
            var selectedValue = this.value;

            if (selectedValue == 1) {
                window.location.href = "{{ route('ganti-akses') }}";
            } else if (selectedValue == 2) {
                window.location.href = "{{ route('ganti-akses') }}";
            }
        });
    </script>
@endif

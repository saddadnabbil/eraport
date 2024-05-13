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
                        if (Auth::user()->hasRole('Admin')) {
                            $dashboard = route('admin.dashboard');
                        } elseif (Auth::user()->hasRole('Teacher')) {
                            $dashboard = route('guru.dashboard');
                        } elseif (Auth::user()->hasRole('Student')) {
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
                    @if (Auth::user()->hasRole('Teacher') && session()->get('cek_wali_kelas') == true)
                        <div style="padding: 0 15px; margin-left: 1rem;">
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link" href="javascript:void(0)">
                                    <div class="customize-input">
                                        <select id="roleSelect"
                                            class="custom-select form-control bg-white custom-radius custom-shadow border-0">
                                            <option value="1" @if (session()->get('akses_sebagai') == 'Guru Mapel' && session()->get('cek_wali_kelas') == true) selected @endif><a
                                                    class="dropdown-item" href="{{ route('akses') }}">
                                                    @if (session()->get('akses_sebagai') == 'Guru Mapel' && session()->get('cek_wali_kelas') == true)
                                                        Teacher
                                                    @else
                                                        Change
                                                        to Teacher
                                                    @endif
                                                </a></option>
                                            <option value="2" @if (session()->get('akses_sebagai') == 'Wali Kelas') selected @endif>
                                                <a class="dropdown-item" href="{{ route('akses') }}">
                                                    @if (session()->get('akses_sebagai') == 'Wali Kelas')
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
                            <a href="{{ Auth::user()->hasRole('Admin') ? route('tapel.index') : 'javascript:void(0)' }}"
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
                    <!-- Notification -->
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
                                        @if (auth()->user()->hasAnyPermission(['admin-access', 'homeroom-pg-kg', 'teacher-pg-kg']))
                                            <a href="{{ auth()->user()->hasRole('Admin') ? route('admin.dashboard') : 'javascript:void(0)' }}"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <div class="btn btn-danger rounded-circle btn-circle"><i
                                                        data-feather="airplay" class="text-white"></i></div>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1 text-nowrap">Admin Access
                                                    </h6>
                                                </div>
                                            </a>
                                        @endif

                                        @if (auth()->user()->hasAnyPermission(['admin-access', 'homeroom-pg-kg', 'teacher-pg-kg']))
                                            <a href="{{ route('tk.penilaian.index') }}"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <div class="btn btn-danger rounded-circle btn-circle"><i
                                                        data-feather="airplay" class="text-white"></i></div>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1 text-nowrap">TK Access
                                                    </h6>
                                                </div>
                                            </a>
                                        @endif

                                        @if (auth()->user()->hasAnyPermission(['admin-access', 'homeroom-km', 'teacher-km']))
                                            <a href="{{ route('tk.penilaian.index') }}"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <div class="btn btn-danger rounded-circle btn-circle"><i
                                                        data-feather="airplay" class="text-white"></i></div>
                                                <div class="w-75 d-inline-block v-middle ps-2">
                                                    <h6 class="message-title mb-0 mt-1 text-nowrap">Kurikulum Merdeka
                                                        Access
                                                    </h6>
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('assets/dist/img/avatar/default.png') }}" alt="user"
                                class="rounded-circle" width="40" />
                            <span class="ms-2 d-none d-lg-inline-block"><span>Hello,</span>
                                <span class="text-dark">
                                    @if (Auth::user()->hasRole('Admin'))
                                        {{ Auth::user()->karyawan->nama_lengkap }}
                                    @elseif(Auth::user()->hasRole('Teacher'))
                                        {{ Auth::user()->karyawan->nama_lengkap }}
                                    @elseif(Auth::user()->hasRole('Student'))
                                        {{ Auth::user()->siswa->nama_lengkap }}
                                    @endif
                                </span>
                                <i data-feather="chevron-down" class="svg-icon"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                            <a class="dropdown-item" href="{{ route('profile') }}"><i data-feather="user"
                                    class="svg-icon me-2 ms-1"></i> My Profile</a>
                            <a class="dropdown-item" href="{{ route('gantipassword') }}"><i data-feather="settings"
                                    class="svg-icon me-2 ms-1"></i>Change Password</a>

                            @if (Auth::user()->hasRole('Teacher'))
                                @if (session()->get('akses_sebagai') == 'Guru Mapel' && session()->get('cek_wali_kelas') == true)
                                    <a class="dropdown-item" href="{{ route('akses') }}"><i
                                            data-feather="toggle-right" class="svg-icon me-2 ms-1"></i> Change to
                                        Homeroom</a>
                                @elseif (session()->get('akses_sebagai') == 'Wali Kelas')
                                    <a class="dropdown-item" href="{{ route('akses') }}"><i
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

    <script>
        document.getElementById('roleSelect').addEventListener('change', function() {
            var selectedValue = this.value;

            if (selectedValue == 1) {
                window.location.href = "{{ route('akses') }}";
            } else if (selectedValue == 2) {
                window.location.href = "{{ route('akses') }}";
            }
        });
    </script>

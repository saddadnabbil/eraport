<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- Logo icon -->
                {{-- <li class="sidebar-item d-flex align-items-center justify-content-center" style="padding-bottom: 30px;">
                    <div class="">
                        <select class=" form-control form-select">
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
                </li> --}}

                @php
                    $user = Auth::user();
                @endphp
                @php
                    $dashboard = route('tu.dashboard');
                @endphp
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="{{ $dashboard }}" aria-expanded="false"><i
                            data-feather="home" class="feather-icon"></i><span class="hide-menu"> Dashboard
                        </span></a>
                </li>
                <li class="list-divider"></li>

                @if (request()->is('admission/*'))
                    @include('layouts.partials.sidebar.tu.pengumuman')
                    @include('layouts.partials.sidebar.tu.siswa')
                    @include('layouts.partials.sidebar.tu.mapel')
                    @include('layouts.partials.sidebar.tu.kelas')
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

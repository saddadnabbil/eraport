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
                    <a class="sidebar-link sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false"><i
                            data-feather="home" class="feather-icon"></i><span class="hide-menu"> Dashboard </span></a>
                </li>
                @include('layouts.partials.sidebar.silabus')
                @include('layouts.partials.sidebar.ekstra')
                @include('layouts.partials.sidebar.reportresultkm.rekapkehadiran')
                @include('layouts.partials.sidebar.timetable')
                @include('layouts.partials.sidebar.reportresultkm.leger')

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

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}" />
    <title>{{$title}} | {{ env('APP_NAME') }}</title>
    <!-- Custom CSS -->
    <link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    {{-- <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div> --}}
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
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
                        <a href="index.html">
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
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->

                        <ul class="navbar-nav float-left me-auto ms-3 ps-1">
                            <div style="padding: 0 15px; margin-left: 1rem;">
                                <a href="{{Auth::user()->role == 1 ? route('tapel.index') : 'javascript:void(0)'}}" style="line-height: 1">
                                    <span class="badge bg-success">
                                    @php
                                        $tapel = App\Tapel::where('status', 1)->first();
                                        $term = App\Term::find($tapel->term_id);
    
                                        $pg = App\Tingkatan::where('id', 1)->first();
                                        $kg = App\Tingkatan::where('id', 2)->first();
                                        $ps = App\Tingkatan::where('id', 3)->first();
                                        $jhs = App\Tingkatan::where('id', 4)->first();
                                        $shs = App\Tingkatan::where('id', 5)->first();
                                        @endphp 
                                        
                                        School Year {{ str_replace('-', ' / ', $tapel->tahun_pelajaran) }} - (Semester PS {{$ps->semester_id . '-' . $ps->term_id}}) - (Semester JHS {{$jhs->semester_id . '-' . $jhs->term_id}}) - (Semester SHS {{$shs->semester_id . '-' . $shs->term_id}}) - Term {{$term->id }}
                                    </span>
                                </a>
                            </div>
                        </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('assets/images/users/profile-pic.jpg') }}" alt="user"
                                    class="rounded-circle" width="40" />
                                <span class="ms-2 d-none d-lg-inline-block"><span>Hello,</span>
                                    <span class="text-dark">
                                        @if (Auth::user()->role == 1)
                                            {{Auth::user()->admin->nama_lengkap}}
                                        @elseif(Auth::user()->role == 2)
                                            {{Auth::user()->guru->nama_lengkap}}
                                        @elseif(Auth::user()->role == 3)
                                            {{Auth::user()->siswa->nama_lengkap}}
                                        @endif
                                        </span>
                                    <i data-feather="chevron-down" class="svg-icon"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                                <a class="dropdown-item" href="{{ route('profile') }}"><i data-feather="user"
                                        class="svg-icon me-2 ms-1"></i> My
                                    Profile</a>
                                <a class="dropdown-item" href="{{ route('gantipassword') }}"><i data-feather="settings"
                                        class="svg-icon me-2 ms-1"></i>
                                    Change Password</a>
                                <div class="dropdown-divider"></div>
                                <a 
                                class="dropdown-item text-danger text-center" 
                                href="{{ route('logout') }}" class="nav-link"
                                aria-expanded="false"
                                onclick="return confirm('Apakah anda yakin ingin keluar ?')"
                                ><i data-feather="power"
                                        class="svg-icon me-2 ms-1 text-danger"></i>
                                    Logout</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->

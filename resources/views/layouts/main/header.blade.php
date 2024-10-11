<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="https://alsyukrouniversal.sch.id/images/favicon_1_.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="https://alsyukrouniversal.sch.id/images/favicon_1_.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="https://alsyukrouniversal.sch.id/images/favicon_1_.ico">
    <link rel="shortcut icon" type="image/x-icon" href="https://alsyukrouniversal.sch.id/images/favicon_1_.ico">
    <link rel="manifest" href="{{ asset('assets/images/favicons/manifest.json') }}">
    <script src="{{ asset('dist/js/config.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <title>{{ $title }} | Perguruan Islam Al-Syukro Universal</title>

    <!-- CSS Kustom -->
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet" />
    {{-- <link href="{{ asset('dist/css/theme.min.css') }}" rel="stylesheet" id="style-default"> --}}
    <!-- Summernote -->
    <link rel="stylesheet" href="{{ asset('assets/libs/summernote/summernote-bs4.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/libs/fontawesome-free/css/all.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    {{-- Select2 --}}
    {{-- <link href="{{ asset('assets/libs/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" rel="stylesheet" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    {{-- datatables --}}
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
    {{-- Style CSS --}}
    @yield('styles')
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

        @php
            $user = Auth::user();
        @endphp

        @include('layouts.partials.topbar.topbar')

        @yield('sidebar')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @yield('content')
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    @yield('footer')
</body>

</html>

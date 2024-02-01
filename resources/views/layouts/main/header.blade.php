<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/dist/img/logo.png') }}" />
        <title>{{$title}} | {{ env('APP_NAME') }}</title>
        
        <!-- CSS Kustom -->
        <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet" />
        <!-- Summernote -->
        <link rel="stylesheet" href="{{ asset('assets/libs/summernote/summernote-bs4.css') }}">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{asset('assets/libs/fontawesome-free/css/all.min.css')}}">
        {{-- datatables --}}
        <!-- <link href="../assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet"> -->
        <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css') }}">

        {{-- Style CSS untuk halaman ini --}}
        @yield('styles')

        <!-- HTML5 Shim dan Respond.js untuk mendukung elemen HTML5 dan kueri media di IE8 -->
        <!-- PERINGATAN: Respond.js tidak akan berfungsi jika Anda melihat halaman melalui file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
            data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
            
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


    


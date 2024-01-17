<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>{{$title}} | {{ env('APP_NAME') }} </title>

  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/dist/img/logo.png')}}">
  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- pace-progress -->
  <link rel="stylesheet" href="/assets/plugins/pace-progress/themes/black/pace-theme-flat-top.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="/assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Custom Css -->
  <link rel="stylesheet" href="/assets/dist/css/custom.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed pace-primary">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>

        <div class="d-flex justify-content-center align-items-center">
          <a href="{{Auth::user()->role == 1 ? route('tapel.index') : '#'}}" class="btn btn-primary btn-sm" style="line-height: 1">
            @php
              $tapel = App\Tapel::find(session()->get('tapel_id'));
              $term = App\Term::find($tapel->term_id);

              $pg = App\Tingkatan::where('id', 1)->first();
              $kg = App\Tingkatan::where('id', 2)->first();
              $ps = App\Tingkatan::where('id', 3)->first();
              $jhs = App\Tingkatan::where('id', 4)->first();
              $shs = App\Tingkatan::where('id', 5)->first();
            @endphp 
             
             School Year {{ str_replace('-', ' / ', $tapel->tahun_pelajaran) }} - (Semester Playgroup {{$pg->semester_id . '-' . $pg->term_id}}) - (Semester Primary {{$ps->semester_id . '-' . $ps->term_id}}) - (Semester Junior High {{$jhs->semester_id . '-' . $jhs->term_id}}) - (Semester Senior High {{$shs->semester_id . '-' . $shs->term_id}}) - Term {{$term->id }}
          </a>
        </div>
        <!-- End of Flex container -->
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown pr-2">
          <!-- User Block  -->
          <a class="user-block" data-toggle="dropdown" href="#">
            @if (Auth::user()->role == 1)
            <img class="img-circle" src="/assets/dist/img/avatar/{{Auth::user()->admin->avatar}}" alt="User Image">
            <span class="username">{{Auth::user()->admin->nama_lengkap}}</span>
            <span class="description">Administrator</span>
            @elseif(Auth::user()->role == 2)
            <img class="img-circle" src="/assets/dist/img/avatar/{{Auth::user()->guru->avatar}}" alt="User Image">
            <span class="username">{{Auth::user()->guru->nama_lengkap}}</span>
            <span class="description">{{session()->get('akses_sebagai')}}</span>
            @else
            <img class="img-circle" src="/assets/dist/img/avatar/{{Auth::user()->siswa->avatar}}" alt="User Image">
            <span class="username">{{Auth::user()->siswa->nama_lengkap}}</span>
            <span class="description">Siswa</span>
            @endif
          </a>
          <!-- End User Block  -->

          <!-- User Dropdown  -->
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Akun Saya</span>
            <div class="dropdown-divider"></div>
            <a href="{{ route('profile') }}" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('gantipassword') }}" class="dropdown-item">
              <i class="fas fa-key mr-2"></i> Ganti Password
            </a>
            
            @if(Auth::user()->role == 2)
            <div class="dropdown-divider"></div>
              @if(session()->get('akses_sebagai') == 'Guru Mapel' && session()->get('cek_wali_kelas') == true)
                <a href="{{ route('akses') }}" class="dropdown-item" onclick="return confirm('Apakah anda yakin akan ganti akses login ?')">
                  <i class="fas fa-chalkboard-teacher mr-2"></i> Akses Sebagai Wali Kelas
                </a>
              @elseif (session()->get('akses_sebagai') == 'Wali Kelas')
                <a href="{{ route('akses') }}" class="dropdown-item" onclick="return confirm('Apakah anda yakin akan ganti akses login ?')">
                  <i class="fas fa-chalkboard-teacher mr-2"></i> Akses Sebagai Guru Mapel
                </a>
              @endif
            @endif
            <div class="dropdown-divider"></div>
            <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer bg-danger" onclick="return confirm('Apakah anda yakin ingin keluar ?')"><i class="fas fa-sign-out-alt mr-1"></i> Keluar / Logout</a>
          </div>
          <!-- End User Dropdown  -->
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->
@extends('layouts.main.header')

@section('styles')
    <link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
@endsection

@section('sidebar')
    @include('layouts.sidebar.walikelas')
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        @php
            $time = date('H');
            $greeting = '';
            if ($time < '12') {
                $greeting = 'Good morning, ';
            } elseif ($time < '18') {
                $greeting = 'Good afternoon, ';
            } else {
                $greeting = 'Good evening, ';
            }

            if (Auth::user()->role == 1) {
                $fullName = optional(Auth::user()->admin)->nama_lengkap ?? 'Admin not available';
            } elseif (Auth::user()->role == 2) {
                $fullName = optional(Auth::user()->karyawan)->nama_lengkap ?? 'Guru not available';
            } elseif (Auth::user()->role == 3) {
                $fullName = optional(Auth::user()->siswa)->nama_lengkap ?? 'Siswa not available';
            }

        @endphp
        @include('layouts.partials.breadcrumbs._breadcrumbs-item', [
            'titleBreadCrumb' => $greeting . $fullName . '!',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('dashboard'),
                    'active' => false,
                ],
            ],
        ])
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">

            <!-- *************************************************************** -->
            <!-- Start First Cards -->
            <!-- *************************************************************** -->
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-end">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="w-80">
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium">{{ $jumlah_anggota_kelas }} </h2>
                                        {{-- <span class="badge bg-primary font-12 text-white font-weight-medium rounded-pill ms-2 d-lg-block d-md-none">+18.33%</span> --}}
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">
                                        Jumlah Siswa
                                    </h6>
                                </div>
                                <div class="ms-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-end">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="w-80">
                                    <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">
                                        {{-- <sup class="set-doller">$</sup>18,306 --}}
                                        {{ $jumlah_kirim_nilai }}
                                    </h2>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">
                                        Jumlah Kirim Nilai
                                    </h6>
                                </div>
                                <div class="ms-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-end">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="w-80">
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium">{{ $jumlah_proses_deskripsi }}</h2>
                                        {{-- <span
                            class="badge bg-danger font-12 text-white font-weight-medium rounded-pill ms-2 d-md-none d-lg-block"
                            >-18.33%</span
                            > --}}
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">
                                        Jumlah Proses Deskripsi
                                    </h6>
                                </div>
                                <div class="ms-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i data-feather="file-plus"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- *************************************************************** -->
            <!-- End First Cards -->
            <!-- *************************************************************** -->


            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- MAP & BOX PANE -->
                    <div class="card">
                        <div class="col-md-12 col-lg-12">
                            <div class="card-body">
                                <h4 class="card-title">Recent Announcement</h4>
                                <div class="mt-4 activity">
                                    @foreach ($data_pengumuman->sortByDesc('created_at') as $pengumuman)
                                        <div class="d-flex align-items-start border-left-line">
                                            <div>
                                                <a href="javascript:void(0)" class="btn btn-cyan btn-circle mb-2 btn-item">
                                                    <i data-feather="bell"></i>
                                                </a>
                                            </div>
                                            <div class="ms-3 mt-2">
                                                <h5 class="text-dark font-weight-medium mb-2 text-wrap">
                                                    {{ $pengumuman->judul }}
                                                </h5>
                                                <div>
                                                    <p class="font-14 mb-2 text-muted text-wrap text-break note-editable">
                                                        {!! $pengumuman->isi !!}
                                                    </p>
                                                </div>
                                                <span
                                                    class="font-weight-light font-14 mb-1 d-block text-muted">{{ $pengumuman->user->admin->nama_lengkap }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($pengumuman->created_at)->diffForHumans() }}</span>
                                                @if (Auth::user()->id == $pengumuman->user_id)
                                                    <form action="{{ route('pengumuman.destroy', $pengumuman->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="font-14 border-bottom text-info pb-1 border-info border-0 bg-transparent"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-edit{{ $pengumuman->id }}">Edit</button>
                                                        <button type="submit"
                                                            class="font-14 border-bottom pb-1 text-danger border-danger border-0 bg-transparent"
                                                            onclick="return confirm('Hapus pengumuman ?')">Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $pengumuman->id }}">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('pengumuman.update', $pengumuman->id) }}"
                                                            method="POST">
                                                            {{ method_field('PATCH') }}
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Judul Pengumuman</label>
                                                                    <input type="text" class="form-control"
                                                                        name="judul" value="{{ $pengumuman->judul }}"
                                                                        readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Isi Pengumuman</label>
                                                                    <textarea class="textarea" name="isi"
                                                                        style="width: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 5px;" required>{!! $pengumuman->isi !!}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-end">
                                                                <button type="button" class="btn btn-default"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal edit -->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-md-4">
                    <!-- PRODUCT LIST -->
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h4 class="card-title">Riwayat Login</h4>
                            <ul class="products-list product-list-in-card">
                                @foreach ($data_riwayat_login as $riwayat_login)
                                    <li class="item">

                                        <div class="product-img">
                                            @if ($riwayat_login->user->role == 1)
                                                <img src="assets/dist/img/avatar/{{ $riwayat_login->user->admin->avatar }}"
                                                    alt="Avatar" class="img-size-50">
                                            @elseif($riwayat_login->user->role == 2)
                                                <img src="assets/dist/img/avatar/{{ $riwayat_login->user->karyawan->avatar }}"
                                                    alt="Avatar" class="img-size-50">
                                            @elseif($riwayat_login->user->role == 3)
                                                <img src="assets/dist/img/avatar/{{ $riwayat_login->user->siswa->avatar }}"
                                                    alt="Avatar" class="img-size-50">
                                            @endif
                                        </div>

                                        <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">
                                                @if ($riwayat_login->user->role == 1)
                                                    {{ $riwayat_login->user->admin->nama_lengkap }}
                                                @elseif($riwayat_login->user->role == 2)
                                                    {{ $riwayat_login->user->karyawan->nama_lengkap }}
                                                @elseif($riwayat_login->user->role == 3)
                                                    {{ $riwayat_login->user->siswa->nama_lengkap }}
                                                @endif

                                                @if ($riwayat_login->status_login == true)
                                                    <span class="badge bg-success float-right">Online</span>
                                                @else
                                                    <span class="badge bg-warning float-right">Offline</span>
                                                @endif

                                            </a>

                                            <span class="product-description">
                                                @if ($riwayat_login->user->role == 1)
                                                    Administrator
                                                @elseif($riwayat_login->user->role == 2)
                                                    Guru
                                                @elseif($riwayat_login->user->role == 3)
                                                    Siswa
                                                @endif

                                                @if ($riwayat_login->status_login == false)
                                                    <span class="time float-right"><i class="far fa-clock"></i>
                                                        {{ $riwayat_login->updated_at->diffForHumans() }}</span>
                                                @endif
                                            </span>
                                        </div>
                                    </li>
                                    <!-- /.item -->
                                @endforeach
                            </ul>
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!--/. container-fluid -->
    </div>
@endsection

<!-- /.content-wrapper -->
@push('custom-scripts')
    <script src="{{ asset('assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/c3/c3.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('dist/js/pages/dashboards/dashboard1.min.js') }}"></script>
@endpush

@include('layouts.main.footer')

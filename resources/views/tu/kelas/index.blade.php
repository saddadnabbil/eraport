@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.tu')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            $dashboard = route('tu.dashboard');
        @endphp
        @include('layouts.partials.breadcrumbs._breadcrumbs-item', [
            'titleBreadCrumb' => $title,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => $dashboard,
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => route('user.index'),
                    'active' => false,
                ],
            ],
        ])
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-layer-group  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Playgroup</span>
                            <span class="info-box-number">{{ $jumlah_kelas_per_tingkatan['1'] }}
                                <small>{{ $jumlah_kelas_per_tingkatan['1'] > 1 ? 'classes' : 'class' }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-book  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Kindergarten A</span>
                            <span class="info-box-number">{{ $jumlah_kelas_per_tingkatan['2'] }}
                                <small>{{ $jumlah_kelas_per_tingkatan['2'] > 1 ? 'classes' : 'class' }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-book  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Kindergarten B</span>
                            <span class="info-box-number">{{ $jumlah_kelas_per_tingkatan['3'] }}
                                <small>{{ $jumlah_kelas_per_tingkatan['3'] > 1 ? 'classes' : 'class' }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <!-- fix for small devices only -->
                {{-- <div class="clearfix hidden-md-up"></div> --}}

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Primary School</span>
                            <span class="info-box-number">{{ $jumlah_kelas_per_tingkatan['4'] }}
                                <small>{{ $jumlah_kelas_per_tingkatan['4'] > 1 ? 'classes' : 'class' }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fas fa-book-reader text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Junior High School</span>
                            <span class="info-box-number">{{ $jumlah_kelas_per_tingkatan['5'] }}
                                <small>{{ $jumlah_kelas_per_tingkatan['5'] > 1 ? 'classes' : 'class' }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fas fa-book-reader  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Senior High School</span>
                            <span class="info-box-number">{{ $jumlah_kelas_per_tingkatan['6'] }}
                                <small>{{ $jumlah_kelas_per_tingkatan['6'] > 1 ? 'class' : 'classes' }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                            <div class="card-tools">
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Semester</th>
                                            <th>Tingkatan</th>
                                            <th>Jurusan</th>
                                            <th>Class</th>
                                            <th>Wali Kelas</th>
                                            <th>Jml Anggota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_kelas as $kelas)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $kelas->tapel->tahun_pelajaran }}
                                                    @if ($kelas->tapel->semester_id == 1)
                                                        Ganjil
                                                    @else
                                                        Genap
                                                    @endif
                                                </td>
                                                <td>{{ $kelas->tingkatan->nama_tingkatan }}</td>
                                                <td>{{ $kelas->jurusan->nama_jurusan }}</td>
                                                <td>{{ $kelas->nama_kelas }}</td>
                                                <td>
                                                    @if ($kelas->guru)
                                                        {{ $kelas->guru->karyawan->nama_lengkap }}
                                                        {{ $kelas->guru->gelar }}
                                                    @else
                                                        Guru not assigned
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('tu.kelas.show', $kelas->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-list"></i>
                                                        @if ($jumlah_anggota_kelas->has($kelas->id))
                                                            <span
                                                                class="info-box-number">{{ $jumlah_anggota_kelas[$kelas->id]->jumlah_anggota }}</span>
                                                        @else
                                                            <span class="info-box-number">0</span>
                                                        @endif
                                                        Siswa
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
@endsection

@section('footer')
    @include('layouts.main.footer')
@endsection

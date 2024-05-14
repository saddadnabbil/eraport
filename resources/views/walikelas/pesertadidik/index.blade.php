@extends('layouts.main.header')

@section('sidebar')
    @include('layouts.sidebar.index')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @include('layouts.partials.breadcrumbs._breadcrumbs-item', [
            'titleBreadCrumb' => $title,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('guru.dashboard'),
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
            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> {{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>NISN</th>
                                            <th>Nama Siswa</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>L/P</th>
                                            <th>Kelas</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_anggota_kelas->sortBy('siswa.nama_lengkap') as $anggota_kelas)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $anggota_kelas->siswa->nis }}</td>
                                                <td>{{ $anggota_kelas->siswa->nisn }}</td>
                                                <td><a class="text-decoration-none text-body"
                                                        href="{{ route('pesertadidik.show', $anggota_kelas->siswa_id) }}">{{ $anggota_kelas->siswa->nama_lengkap }}
                                                    </a></td>
                                                <td>{{ $anggota_kelas->siswa->tempat_lahir }}</td>
                                                <td>{{ $anggota_kelas->siswa->tanggal_lahir->format('d-M-Y') }}</td>
                                                <td>{{ $anggota_kelas->siswa->jenis_kelamin }}</td>
                                                <td>{{ $anggota_kelas->kelas->nama_kelas }}</td>
                                                <td>
                                                    <div data-bs-toggle="tooltip" data-bs-original-title="Show"
                                                        class="text-center">
                                                        <a href="{{ route('pesertadidik.show', $anggota_kelas->siswa_id) }}"
                                                            class="btn btn-info btn-sm mt-1">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
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

@extends('layouts.main.header')

@section('sidebar')
    @include('layouts.sidebar.siswa')
@endsection
@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            if (
                $user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) &&
                $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])
            ) {
                $dashboard = route('guru.dashboard');
            } elseif ($user->hasAnyRole(['Student']) && $user->hasAnyPermission(['student'])) {
                $dashboard = route('siswa.dashboard');
            } else {
                $dashboard = route('admin.dashboard');
            }
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
            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> {{ $title }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-info">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        Full name
                                    </div>
                                    <div class="col-sm-9">
                                        : {{ $siswa->nama_lengkap }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        Nomor Induk / NISN
                                    </div>
                                    <div class="col-sm-9">
                                        : {{ $siswa->nis }} / {{ $siswa->nisn }}
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="bg-info">
                                        <tr>
                                            <th class="text-center" rowspan="2" style="width: 5%;">No</th>
                                            <th class="text-center" rowspan="2" style="width: 25%;">Nama Ekstrakulikuler
                                            </th>
                                            <th class="text-center" rowspan="2" style="width: 20%;">Pembina</th>
                                            <th class="text-center" colspan="2" style="width: 50%;">Nilai Ekstrakulikuler
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" style="width: 10%;">Nilai</th>
                                            <th class="text-center" style="width: 40%;">Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_anggota_ekstra->sortBy('ekstrakulikuler.nama_ekstrakulikuler') as $anggota_ekstra)
                                            <?php $no++; ?>
                                            <tr>
                                                <td class="text-center">{{ $no }}</td>
                                                <td>{{ $anggota_ekstra->ekstrakulikuler->nama_ekstrakulikuler }}</td>
                                                <td>{{ $anggota_ekstra->ekstrakulikuler->pembina->nama_lengkap }}
                                                    {{ $anggota_ekstra->ekstrakulikuler->pembina->gelar }}</td>
                                                @if (!is_null($anggota_ekstra->nilai))
                                                    <td class="text-center">
                                                        {{ $anggota_ekstra->nilai->nilai }}
                                                    </td>
                                                    <td>{{ $anggota_ekstra->nilai->deskripsi }}</td>
                                                @else
                                                    <td class="text-center"></td>
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
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

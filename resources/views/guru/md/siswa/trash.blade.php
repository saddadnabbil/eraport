@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.guru')
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
                    'url' => route('admin.dashboard'),
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => route('guru.siswa.trash'),
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
                                            <th>Name</th>
                                            <th>Level</th>
                                            <th>Class</th>
                                            <th>NIS</th>
                                            <th>NISN</th>
                                            <th>Sex</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($siswaTrashed as $siswa)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $siswa->nama_lengkap }}</td>
                                                <td>
                                                    @if ($siswa->kelas_id == null)
                                                        <span class="badge light bg-warning">Belum terdata</span>
                                                    @else
                                                        {{ $siswa->kelas->tingkatan->nama_tingkatan }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($siswa->kelas_id == null)
                                                        <span class="badge light bg-warning">Belum masuk anggota
                                                            kelas</span>
                                                    @else
                                                        {{ $siswa->kelas->nama_kelas }}
                                                    @endif
                                                </td>
                                                <td>{{ $siswa->nis }}</td>
                                                <td>{{ $siswa->nisn }}</td>
                                                <td>{{ $siswa->jenis_kelamin }}</td>
                                                <td>
                                                    @if ($siswa->user->status == true && $siswa->status == true)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Non Active</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex gap-2">
                                                        @include('components.actions.restore-button', [
                                                            'route' => route('guru.siswa.restore', [
                                                                'id' => $siswa->id,
                                                            ]),
                                                            'id' => $siswa->id,
                                                            'method' => 'PATCH',
                                                        ])
                                                        @include('components.actions.delete-button', [
                                                            'route' => route('guru.siswa.permanent-delete', [
                                                                'id' => $siswa->id,
                                                            ]),
                                                            'isPermanent' => false,
                                                            'id' => $siswa->id,
                                                            'withEdit' => false,
                                                            'withShow' => false,
                                                        ])
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

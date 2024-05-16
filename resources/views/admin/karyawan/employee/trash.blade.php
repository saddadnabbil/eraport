@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.index')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            if (
                $user->hasAnyRole(['Teacher', 'Curriculum']) &&
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
                    'title' => 'Data Karyawan',
                    'url' => route('karyawan.index'),
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => route('karyawan.index'),
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Employee Code</th>
                                            <th>Employee Name</th>
                                            <th>Join Date</th>
                                            <th>Resign Date</th>
                                            <th>Sex</th>
                                            <th>Status Employee</th>
                                            <th>Unit</th>
                                            <th>Position</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($karyawanTrashed as $karyawan)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $karyawan->kode_karyawan }}</td>
                                                <td>{{ $karyawan->nama_lengkap }}</td>
                                                <td>{{ $karyawan->join_date }}</td>
                                                <td>{{ $karyawan->resign_date }}</td>
                                                <td>{{ $karyawan->jenis_kelamin }}</td>
                                                <td>{{ $karyawan->statusKaryawan->status_nama }}</td>
                                                <td>{{ $karyawan->unitKaryawan->unit_nama }}</td>
                                                <td>{{ $karyawan->positionKaryawan->position_nama }}</td>
                                                <td>
                                                    @if ($karyawan->status == true)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Non Aktif</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2">
                                                        @include('components.actions.restore-button', [
                                                            'route' => route('karyawan.restore', $karyawan->id),
                                                            'id' => $karyawan->id,
                                                            'method' => 'POST',
                                                        ])
                                                        @include('components.actions.delete-button', [
                                                            'route' => route(
                                                                'karyawan.permanent-delete',
                                                                $karyawan->id),
                                                            'id' => $karyawan->id,
                                                            'isPermanent' => false,
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

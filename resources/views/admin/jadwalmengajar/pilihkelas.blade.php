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
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="callout callout-info">
                                <form action="{{ route('jadwalmengajar.create') }}" method="GET">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="pembelajaran_id" class="col-sm-3 col-form-label">Kelas</label>
                                        <div class="col-sm-9">
                                            <select class="form-control form-select select2" name="guru_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="" selected>-- Pilih Kelas --</option>
                                                @foreach ($dataGuru as $guru)
                                                    <option value="{{ $guru->id }}">
                                                        {{ $guru->karyawan->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
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

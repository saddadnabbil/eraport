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
                                <form action="{{ route('cp.create') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="pembelajaran_id" class="col-sm-3 col-form-label">Kelas</label>
                                        <div class="col-sm-9">
                                            <select class="form-control form-select select2" name="pembelajaran_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="">-- Pilih Kelas --</option>
                                                @foreach ($data_pembelajaran as $pembelajaran)
                                                    <option value="{{ $pembelajaran->id }}">
                                                        {{ $pembelajaran->mapel->nama_mapel }}
                                                        ({{ $pembelajaran->kelas->nama_kelas }} -
                                                        {{ $pembelajaran->kelas->tingkatan->nama_tingkatan }})
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

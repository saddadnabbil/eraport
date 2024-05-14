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
                                <form action="{{ route('tk.point.create') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="term_id" class="col-sm-2 col-form-label">Term</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select select2" name="term_id"
                                                style="width: 100%;" required>
                                                <option value="">-- Pilih Term --</option>
                                                @foreach ($data_term as $term)
                                                    <option value="{{ $term->id }}">
                                                        {{ $term->term }}
                                                @endforeach
                                            </select>
                                        </div>
                                        <label for="tingkatan_id" class="col-sm-2 col-form-label">Tingkatan</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select select2" name="tingkatan_id"
                                                style="width: 100%;" required" onchange="this.form.submit();">
                                                <option value="">-- Pilih Tingkatan --</option>
                                                @foreach ($data_tingkatan as $tingkatan)
                                                    <option value="{{ $tingkatan->id }}">
                                                        {{ $tingkatan->nama_tingkatan }}
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

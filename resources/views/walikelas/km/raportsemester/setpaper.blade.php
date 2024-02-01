@include('layouts.main.header')
@include('layouts.sidebar.walikelas')

@extends('layouts.main.header')

@section('sidebar')
  @include('layouts.sidebar.guru')
@endsection

@section('content')
  <div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    @include('layouts.partials.breadcrumbs._breadcrumbs-item', [
        'breadcrumbs' => [
            [
                'title' => 'Dashboard',
                'url' => route('dashboard'),
                'active' => true,
            ],
            [
                'title' => $title,
                'url' => route('user.index'),
                'active' => false,
            ]
        ]
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
              <h3 class="card-title"><i class="fas fa-print"></i> {{$title}}</h3>
            </div>

            <div class="card-body">
              <div class="callout callout-info">
                <form action="{{ route('raportsemesterkm.store') }}" method="POST">
                  @csrf
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Semester</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="semester_id" style="width: 100%;" required onchange="this.form.submit()">
                          <option value="" selected>-- Pilih Semester --</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                      </select>
                    </div>
                  </div>
                </form>
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
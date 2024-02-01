@include('layouts.main.header')
@include('layouts.sidebar.siswa')

@extends('layouts.main.header')

@section('sidebar')
  @include('layouts.sidebar.admin')
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
              <h3 class="card-title"><i class="fas fa-book-reader"></i> {{$title}}</h3>
            </div>
            <div class="card-body">
              <div class="callout callout-info">
                <div class="form-group row">
                  <div class="col-sm-3">
                    Nama Lengkap
                  </div>
                  <div class="col-sm-9">
                    : {{$siswa->nama_lengkap}}
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-3">
                    Nomor Induk / NISN
                  </div>
                  <div class="col-sm-9">
                    : {{$siswa->nis}} / {{$siswa->nisn}}
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead class="bg-info">
                    <tr>
                      <th class="text-center" rowspan="2" style="width: 5%;">No</th>
                      <th class="text-center" rowspan="2" style="width: 28%;">Mata Pelajaran</th>
                      <th class="text-center" rowspan="2" style="width: 7%;">KKM</th>
                      <th class="text-center" colspan="2" style="width: 15%;">Sumatif</th>
                      <th class="text-center" colspan="2" style="width: 15%;">Formatif</th>
                    </tr>
                    <tr>
                      <th class="text-center" style="width: 7%;">Nilai</th>
                      <th class="text-center" style="width: 8%;">Predikat</th>
                      <th class="text-center" style="width: 7%;">Nilai</th>
                      <th class="text-center" style="width: 8%;">Predikat</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 0; ?>
                    @foreach($data_pembelajaran->sortBy('mapel.nama_mapel') as $pembelajaran)
                    <?php $no++; ?>
                    <tr>
                      <td class="text-center">{{$no}}</td>
                      <td>{{$pembelajaran->mapel->nama_mapel}}</td>
                      @if(!is_null($pembelajaran->nilai))
                      <td class="text-center">{{$pembelajaran->nilai->kkm}}</td>
                      <td class="text-center">{{$pembelajaran->nilai->nilai_sumatif}}</td>
                      <td class="text-center">{{$pembelajaran->nilai->predikat_sumatif}}</td>
                      <td class="text-center">{{$pembelajaran->nilai->nilai_formatif}}</td>
                      <td class="text-center">{{$pembelajaran->nilai->predikat_formatif}}</td>
                      @else
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
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
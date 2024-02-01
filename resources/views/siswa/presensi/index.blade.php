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
                <table class="table table-bordered">
                  <thead class="bg-info">
                    <tr>
                      <th class="text-center" rowspan="2" style="width: 40%;">Kelas</th>
                      <th class="text-center" colspan="3" style="width: 60%;">Jumlah Ketidakhadiran</th>
                    </tr>
                    <tr>
                      <th class="text-center" style="width: 20%;">Sakit</th>
                      <th class="text-center" style="width: 20%;">Izin</th>
                      <th class="text-center" style="width: 20%;">Tanpa Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      @if(is_null($kehadiran) && !is_null($anggota_kelas))
                      <td class="text-center">
                        {{$anggota_kelas->kelas->nama_kelas}} 
                      </td>
                      <td class="text-center">-</td>
                      <td class="text-center">-</td>
                      <td class="text-center">-</td>
                      @else
                      <td class="text-center">
                        @dd($kehadiran)
                        {{$anggota_kelas->kelas->nama_kelas}} {{$kehadiran->anggota_kelas->kelas->tapel->tahun_pelajaran}}
                        @if($kehadiran->anggota_kelas->kelas->tapel->semester == 1)
                        Ganjil
                        @else
                        Genap
                        @endif
                      </td>
                      <td class="text-center">{{$kehadiran->sakit}}</td>
                      <td class="text-center">{{$kehadiran->izin}}</td>
                      <td class="text-center">{{$kehadiran->tanpa_keterangan}}</td>
                      @endif
                    </tr>
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
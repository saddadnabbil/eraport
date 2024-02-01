@include('layouts.main.header')
@include('layouts.sidebar.siswa')

@section('this-page-styles')
  <link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
@endsection

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{$title}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Info -->
      <div class="callout callout-success">
        <h5>{{$sekolah->nama_sekolah}}</h5>
        <p>Tahun Pelajaran {{$tapel->tahun_pelajaran}}
          @if($tapel->semester_id == 1)
          Semester Ganjil
          @else
          Semester Genap
          @endif
        </p>
      </div>
      <!-- End Info  -->

      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-6">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-book-reader"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jumlah Ekstrakulikuler</span>
              <span class="info-box-number">
                {{$jumlah_ekstrakulikuler}} <small>yang diikuti</small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-6">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-book"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jumlah Mata Pelajaran</span>
              <span class="info-box-number">
                {{$jumlah_mapel}} <small>yang dipelajari</small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- MAP & BOX PANE -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Pengumuman</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-bs-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-bs-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body pr-1">
              <div class="row">
                <div class="col-md-12">
                  <!-- The time line -->
                  <div class="timeline">
                    <!-- timeline time label -->
                    <div class="time-label">
                      <span class="bg-success">Pengumuman Terakhir</span>
                    </div>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    @foreach($data_pengumuman->sortByDesc('created_at') as $pengumuman)
                    <div>
                      <i class="fas fa-envelope bg-primary"></i>
                      <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> {{$pengumuman->created_at}}</span>

                        <h3 class="timeline-header"><a href="#">{{$pengumuman->user->admin->nama_lengkap}}</a> {{$pengumuman->judul}} @if($pengumuman->created_at != $pengumuman->updated_at)<small><i>edited</i></small>@endif</h3>

                        <div class="timeline-body">
                          {!! $pengumuman->isi !!}
                        </div>
                      </div>
                    </div>
                    @endforeach
                    <!-- END timeline item -->
                    <div>
                      <i class="fas fa-clock bg-gray"></i>
                    </div>
                  </div>
                </div>
                <!-- /.col -->
              </div>
            </div>
            <!-- /.card-body -->
          </div>

        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <!-- PRODUCT LIST -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Riwayat Login</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-bs-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-bs-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                @foreach($data_riwayat_login as $riwayat_login)
                <li class="item">

                  @if($riwayat_login->user->role == 1 && $riwayat_login->user->role == 2)
                  @elseif($riwayat_login->user->role == 3)
                  <div class="product-img">
                    <img src="assets/dist/img/avatar/{{$riwayat_login->user->siswa->avatar}}" alt="Avatar" class="img-size-50">
                  </div>
                    @endif

                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title">
                      @if($riwayat_login->user->role == 1 &&  $riwayat_login->user->role == 2)
                      @elseif($riwayat_login->user->role == 3)
                      {{$riwayat_login->user->siswa->nama_lengkap}}
                      @endif

                      @if($riwayat_login->status_login == true && $riwayat_login->user->role == 3)
                      <span class="badge bg-success float-right">Online</span>
                      @elseif ($riwayat_login->status_login == false && $riwayat_login->user->role == 3)
                      <span class="badge bg-warning float-right">Offline</span>
                      @endif

                    </a>

                    <span class="product-description">
                      @if($riwayat_login->user->role == 1 && $riwayat_login->user->role == 2)

                      @elseif($riwayat_login->user->role == 3)
                      Siswa
                      @endif

                      @if($riwayat_login->status_login == false && $riwayat_login->user->role == 3)
                        <span class="time float-right"><i class="far fa-clock"></i> {{$riwayat_login->updated_at->diffForHumans()}}</span>
                      @endif
                    </span>
                  </div>
                </li>
                <!-- /.item -->
                @endforeach
              </ul>
            </div>
            <!-- /.card-body -->

          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@push('custom-scripts')
  <script src="{{ asset('assets/extra-libs/c3/d3.min.js') }}"></script>
  <script src="{{ asset('assets/extra-libs/c3/c3.min.js') }}"></script>
  <script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
  <script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
  <script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
  <script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
  <script src="{{ asset('dist/js/pages/dashboards/dashboard1.min.js') }}"></script>
@nedpush

@include('layouts.main.footer')
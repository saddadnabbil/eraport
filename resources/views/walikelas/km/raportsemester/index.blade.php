@include('layouts.main.header')
@include('layouts.sidebar.walikelas')

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
            <li class="breadcrumb-item "><a href="{{ route('dashboard') }}">Dashboard</a></li>
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
                      <select class="form-control" name="semester_id" style="width: 100%;" required >
                          <option value="1" @if( $tapel->semester_id  == '1' ) selected @endif>1</option>
                          <option value="2" @if( $tapel->semester_id  == '2' ) selected @endif>2</option>
                      </select>
                    </div>
                  </div>
                  <input type="hidden" name="paper_size" value="{{ $paper_size }}">
                  <input type="hidden" name="orientation" value="{{ $orientation }}">
                </form>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead class="bg-info">
                    <tr>
                      <th class="text-center" style="width: 5%;">No</th>
                      <th class="text-center" style="width: 5%;">NIS</th>
                      <th class="text-center" style="width: 50%;">Nama Siswa</th>
                      <th class="text-center" style="width: 5%;">L/P</th>
                      <th class="text-center" style="width: 15%;">Kelengkapan Raport</th>
                      <th class="text-center" style="width: 15%;">Raport</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 0; ?>
                    @if(!$data_anggota_kelas->isEmpty())
                      @foreach($data_anggota_kelas->sortBy('siswa.nama_lengkap') as $anggota_kelas)
                      <?php $no++; ?>
                      <tr>
                        <input type="hidden" name="anggota_kelas_id[]" value="{{$anggota_kelas->id}}">
                        <td class="text-center">{{$no}}</td>
                        <td class="text-center">{{$anggota_kelas->siswa->nis}}</td>
                        <td>{{$anggota_kelas->siswa->nama_lengkap}}</td>
                        <td class="text-center">{{$anggota_kelas->siswa->jenis_kelamin}}</td>
                        <td class="text-center">
                          <form action="{{ route('raportsemesterkm.show', $anggota_kelas->id) }}" target="_black" method="GET">
                            @csrf
                            <input type="hidden" name="data_type" value="1">
                            <input type="hidden" name="paper_size" value="{{$paper_size}}">
                            <input type="hidden" name="orientation" value="{{$orientation}}">
                            <input type="hidden" name="semester_id" value="{{$semester->id}}">
                            <button type="submit" class="btn btn-danger btn-sm">
                              <i class="fas fa-print"></i> Cetak Data
                            </button>
                          </form>
                        </td>
                        <td class="text-center">
                          <form action="{{ route('raportsemesterkm.show', $anggota_kelas->id) }}" target="_black" method="GET">
                            @csrf
                            <input type="hidden" name="data_type" value="2">
                            <input type="hidden" name="paper_size" value="{{$paper_size}}">
                            <input type="hidden" name="orientation" value="{{$orientation}}">
                            <input type="hidden" name="semester_id" value="{{$semester->id}}">
                            <button type="submit" class="btn btn-primary btn-sm">
                              <i class="fas fa-print"></i> Cetak Raport
                            </button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                    @else
                      <tr>
                        <td class="text-center" colspan="12">Data tidak tersedia.</td>
                      </tr>
                    @endif
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
    <!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('layouts.main.footer')
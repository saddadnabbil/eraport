@include('layouts.main.header')
@include('layouts.sidebar.admin')

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
              <h3 class="card-title"><i class="fas fa-eye"></i> {{$title}}</h3>
            </div>

            <div class="card-body">
              <div class="callout callout-info">
                <form action="{{ route('nilaiterkirimkmadmin.create') }}" method="GET">
                  @csrf
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Mata Pelajaran</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" name="pembelajaran_id" style="width: 100%;" required onchange="this.form.submit();">
                        <option value="" disabled>-- Pilih Pembelajaran --</option>
                        @foreach($data_pembelajaran as $mapel)
                        <option value="{{$mapel->id}}" @if($mapel->id == $pembelajaran->id) selected @endif>{{$mapel->mapel->nama_mapel}} {{$mapel->kelas->nama_kelas}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </form>
              </div>

              <!-- Nilai -->

              <div class="card">
                <div class="card-header bg-success">
                  <h3 class="card-title"><i class="fas fa-file-invoice"></i> Nilai Raport Terkirim</h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                      <thead class="bg-info">
                        <tr>
                          <th rowspan="2" class="text-center" style="vertical-align: middle">No</th>
                          <th rowspan="2" class="text-center" style="vertical-align: middle">Nama Siswa</th>
                          <th rowspan="2" class="text-center" style="vertical-align: middle">KKM</th>
                          <th colspan="2" class="text-center">Sumatif</th>
                          <th colspan="2" class="text-center">Formatif</th>
                          <th colspan="2" class="text-center">Akhir</th>
                        </tr>
                        <tr>
                          <th class="text-center">Nilai</th>
                          <th class="text-center">Predikat</th>
                          <th class="text-center">Nilai</th>
                          <th class="text-center">Predikat</th>
                          <th class="text-center">Nilai</th>
                          <th class="text-center">Predikat</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 0; ?>
                        @if($data_nilai_terkirim->isEmpty())
                            <tr>
                                <td colspan="9" class="text-center">Data tidak tersedia</td>
                            </tr>
                        @else
                            @foreach($data_nilai_terkirim->sortBy('anggota_kelas.siswa.nama_lengkap') as $nilai_terkirim)
                                <?php $no++; ?>
                                <tr>
                                    <td class="text-center" style="width: 100px;">{{$no}}</td>
                        
                                    <td>{{$nilai_terkirim->anggota_kelas->siswa->nama_lengkap}}</td>
                                    <td class="text-center">{{$nilai_terkirim->kkm}}</td>
                        
                                    <td class="text-center">{{$nilai_terkirim->nilai_sumatif}}</td>
                                    <td class="text-center">{{$nilai_terkirim->predikat_sumatif}}</td>
                                    <td class="text-center">{{$nilai_terkirim->nilai_formatif}}</td>
                                    <td class="text-center">{{$nilai_terkirim->predikat_formatif}}</td>
                        
                                    <td class="text-center">{{$nilai_terkirim->nilai_akhir_raport}}</td>
                                    <td class="text-center">{{$nilai_terkirim->predikat_akhir_raport}}</td>
                                </tr>
                            @endforeach
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>
          </div> <!-- /.card -->
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

</body>

</html>
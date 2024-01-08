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
              <h3 class="card-title"><i class="fas fa-table"></i> {{$title}}</h3>
            </div>

            <div class="card-body">
              <div class="callout callout-info">
                <form action="{{ route('adminlegerkm.store') }}" method="POST">
                  @csrf
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kelas</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" name="kelas_id" style="width: 100%;" required onchange="this.form.submit();">
                        <option value="" disabled>-- Pilih Kelas --</option>
                        @foreach($data_kelas->sortBy('tingkatan_id') as $kls)
                        <option value="{{$kls->id}}" @if($kls->id == $kelas->id) selected @endif>{{$kls->nama_kelas}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </form>
              </div>

              <div>
                <a href="{{ route('adminlegerkm.show', $kelas->id) }}" class="btn btn-primary float-right"><i class="fas fa-download"></i> Download Leger</a>
              </div>

              <div class="table-responsive pt-3">
                <table class="table table-bordered table-striped">
                  <thead class="bg-info">
                    <tr>
                      <th rowspan="2" class="text-center" style="width: 50px;">No</th>
                      <th rowspan="2" class="text-center" style="width: 50px;">NIS</th>
                      <th rowspan="2" class="text-center">Nama Siswa</th>
                      <th rowspan="2" class="text-center" style="width: 50px;">Kelas</th>
                      <th colspan="2" class="text-center">Rata-Rata</th>
                      <th colspan="3" class="text-center">Kehadiran</th>
                      <th colspan="{{$count_ekstrakulikuler}}" class="text-center">Ekstrakulikuler</th>
                    </tr>
                    <tr>
                      <th class="text-center">Sumatif</th>
                      <th class="text-center">Formatif</th>
                      <th class="text-center">S</th>
                      <th class="text-center">I</th>
                      <th class="text-center">A</th>

                      @foreach($data_ekstrakulikuler->sortBy('id') as $ekstrakulikuler)
                        <th class="text-center">{{$ekstrakulikuler->nama_ekstrakulikuler}}</th>
                      @endforeach

                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 0; ?>
                    @foreach($data_anggota_kelas->sortBy('siswa.nama_lengkap') as $anggota_kelas)
                    <?php $no++; ?>
                    <tr>
                      <td class="text-center">{{$no}}</td>
                      <td class="text-center">{{$anggota_kelas->siswa->nis}}</td>
                      <td>{{$anggota_kelas->siswa->nama_lengkap}}</td>
                      <td class="text-center">{{$anggota_kelas->kelas->nama_kelas}}</td>

                      <td class="text-center">{{$anggota_kelas->rata_rata_sumatif}}</td>
                      <td class="text-center">{{$anggota_kelas->rata_rata_formatif}}</td>

                      @if(!is_null($anggota_kelas->kehadiran_siswa))
                        <td class="text-center">{{$anggota_kelas->kehadiran_siswa->sakit}}</td>
                        <td class="text-center">{{$anggota_kelas->kehadiran_siswa->izin}}</td>
                        <td class="text-center">{{$anggota_kelas->kehadiran_siswa->tanpa_keterangan}}</td>
                      @else
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                      @endif

                      @foreach($anggota_kelas->data_nilai_ekstrakulikuler as $nilai_ekstrakulikuler)
                        @if($nilai_ekstrakulikuler->nilai == 1)
                          <td class="text-center">Kurang</td>
                        @elseif($nilai_ekstrakulikuler->nilai == 2)
                          <td class="text-center">Cukup</td>
                        @elseif($nilai_ekstrakulikuler->nilai == 3)
                          <td class="text-center">Baik</td>
                        @elseif($nilai_ekstrakulikuler->nilai == 4)
                          <td class="text-center">Sangat Baik</td>
                        @else
                          <td class="text-center">-</td>
                        @endif
                      @endforeach
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
    <!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('layouts.main.footer')
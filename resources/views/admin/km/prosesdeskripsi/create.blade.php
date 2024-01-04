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
              <h3 class="card-title"><i class="fas fa-file-alt"></i> {{$title}}</h3>
            </div>

            <div class="card-body">
              <div class="callout callout-info">
                <form action="{{ route('prosesdeskripsikmadmin.create') }}" method="GET">
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
                <div class="card-header bg-primary">
                  <h3 class="card-title"><i class="fas fa-file-alt"></i> Deskripsi Nilai Siswa</h3>
                </div>
                <form action="{{ route('prosesdeskripsikmadmin.store') }}" method="POST">
                  @csrf
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead class="bg-info">
                          <tr>
                            <th rowspan="2" class="text-center" style="width: 75px; vertical-align: middle">No</th>
                            <th rowspan="2" class="text-center" style="vertical-align: middle">Nama Siswa</th>
                            <th colspan="2" class="text-center">Nilai Sumatif</th>
                            <th colspan="2" class="text-center">Nilai Formatif</th>
                          </tr>
                          <tr>
                            <th class="text-center" style="width: 50px;">Nilai</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center" style="width: 50px;">Nilai</th>
                            <th class="text-center">Deskripsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <input type="hidden" name="pembelajaran_id" value="{{$pembelajaran->id}}">

                          <?php $no = 0; ?>
                          @forelse($data_nilai_siswa->sortBy('anggota_kelas.siswa.nama_lengkap') as $nilai_siswa)
                          <?php $no++; ?>
                          <input type="hidden" name="nilai_akhir_raport_id[]" value="{{$nilai_siswa->id}}">
                          <tr>
                            <td class="text-center">{{$no}}</td>
                            <td>{{$nilai_siswa->anggota_kelas->siswa->nama_lengkap}}</td>

                            <td class="text-center">{{$nilai_siswa->nilai_formatif}}</td>
                            <td>
                              <textarea class="form-control" name="deskripsi_sumatif[]" rows="4" minlength="30" maxlength="200" required oninvalid="this.setCustomValidity('Deskripsi sumatif harus berisi antara 30 s/d 200 karekter')" oninput="setCustomValidity('')">{{ $nilai_siswa->deskripsi_nilai_siswa->deskripsi_sumatif ?? 
                                ($nilai_siswa->predikat_sumatif == 'D' ? 'Memiliki penguasaan sumatif kurang baik, terutama ' . $nilai_siswa->deskripsi_sumatif : 
                                 ($nilai_siswa->predikat_sumatif == 'C' ? 'Memiliki penguasaan sumatif cukup baik, terutama ' . $nilai_siswa->deskripsi_sumatif : 
                                  ($nilai_siswa->predikat_sumatif == 'B' ? 'Memiliki penguasaan sumatif baik, terutama dalam ' . $nilai_siswa->deskripsi_sumatif : 
                                   'Memiliki penguasaan sumatif sangat baik, terutama dalam ' . $nilai_siswa->deskripsi_sumatif))) }}</textarea>
                            </td>

                            <td class="text-center">{{$nilai_siswa->nilai_formatif}}</td>
                            <td>
                              <textarea class="form-control" name="deskripsi_formatif[]" rows="4" minlength="30" maxlength="200" required oninvalid="this.setCustomValidity('Deskripsi formatif harus berisi antara 30 s/d 200 karekter')" oninput="setCustomValidity('')">{{ $nilai_siswa->deskripsi_nilai_siswa->deskripsi_formatif ?? 
                                ($nilai_siswa->predikat_formatif == 'D' ? 'Memiliki penguasaan formatif kurang baik, terutama ' . $nilai_siswa->deskripsi_formatif : 
                                 ($nilai_siswa->predikat_formatif == 'C' ? 'Memiliki penguasaan formatif cukup baik, terutama ' . $nilai_siswa->deskripsi_formatif : 
                                  ($nilai_siswa->predikat_formatif == 'B' ? 'Memiliki penguasaan formatif baik, terutama dalam ' . $nilai_siswa->deskripsi_formatif : 
                                   'Memiliki penguasaan formatif sangat baik, terutama dalam ' . $nilai_siswa->deskripsi_formatif))) }}
                              </textarea>
                            </td>

                          </tr>
                          @empty
                            <tr>
                                <td colspan="6" class="text-center">Data tidak tersedia</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer clearfix">
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                    <a href="{{ route('prosesdeskripsikmadmin.index') }}" class="btn btn-default float-right mr-2">Batal</a>
                  </div>
                </form>
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
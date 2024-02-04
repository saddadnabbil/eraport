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
                'title' => 'Nilai Ekstrakulikuler',
                'url' => route('nilaiekstraadmin.index'),
                'active' => true,
            ],
            [
                'title' => $title,
                'url' => '',
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
              <h3 class="card-title"> {{$title}}</h3>
            </div>

            <div class="card-body">
              <div class="callout callout-info">
                <form action="{{ route('nilaiekstraadmin.create') }}" method="GET">
                  @csrf
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ekstrakulikuler</label>
                    <div class="col-sm-10">
                      <select class="form-control form-select select2" name="ekstrakulikuler_id" style="width: 100%;" required>
                        <option value="" disabled>-- Pilih Ekstrakulikuler --</option>
                        @foreach($data_ekstrakulikuler as $ekstra)
                        <option value="{{$ekstra->id}}" @if($ekstrakulikuler->id == $ekstra->id) selected @endif>{{$ekstra->nama_ekstrakulikuler}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kelas</label>
                    <div class="col-sm-10">
                      <select class="form-control form-select select2" name="kelas_id" style="width: 100%;" required onchange="this.form.submit();">
                        <option value="" disabled>-- Pilih Kelas --</option>
                        @foreach($data_kelas as $kls)
                        <option value="{{$kls->id}}" @if($kls->id == $kelas->id) selected @endif>{{$kls->nama_kelas}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </form>
              </div>

              <!-- Nilai -->

              <div class="card">
                <div class="card-header bg-primary">
                  <h3 class="card-title"> Nilai Ekstrakulikuler</h3>
                </div>
                <form action="{{ route('nilaiekstraadmin.store') }}" method="POST">
                  @csrf
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead class="bg-info">
                          <tr>
                            <th class="text-center" style="width: 4%;">No</th>
                            <th class="text-center" style="width: 25%;">Nama Siswa</th>
                            <th class="text-center" style="width: 4%;">L/P</th>
                            <th class="text-center" style="width: 7%;">Kelas</th>
                            <th class="text-center" style="width: 10%;">Ekstrakulikuler</th>
                            <th class="text-center" style="width: 10%;">Nilai</th>
                            <th class="text-center" style="width: 40%;">Deskripsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <input type="hidden" name="ekstrakulikuler_id" value="{{$ekstrakulikuler->id}}">

                          <?php $no = 0; ?>
                          @if (!$data_anggota_ekstrakulikuler->isEmpty())
                            @foreach($data_anggota_ekstrakulikuler->sortBy('anggota_kelas.siswa.nama_lengkap') as $anggota_ekstrakulikuler)
                              <?php $no++; ?>
                              <input type="hidden" name="anggota_ekstrakulikuler_id[]" value="{{$anggota_ekstrakulikuler->id}}">
                              <tr>
                                <td class="text-center">{{$no}}</td>
                                <td>{{$anggota_ekstrakulikuler->anggota_kelas->siswa->nama_lengkap}}</td>
                                <td class="text-center">{{$anggota_ekstrakulikuler->anggota_kelas->siswa->jenis_kelamin}}</td>
                                <td class="text-center">{{$anggota_ekstrakulikuler->anggota_kelas->kelas->nama_kelas}}</td>
                                <td class="text-center">{{$anggota_ekstrakulikuler->ekstrakulikuler->nama_ekstrakulikuler}}</td>
                                <td>
                                  <select class="form-control form-select" name="nilai[]" style="width: 100%;" required oninvalid="this.setCustomValidity('silakan pilih item dalam daftar')" oninput="setCustomValidity('')">
                                    @if(is_null($anggota_ekstrakulikuler->nilai))
                                    <option value="A">A</option>
                                    <option value="B" selected>B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    @else
                                    <option value="A" @if($anggota_ekstrakulikuler->nilai == 'A') selected @endif>A</option>
                                    <option value="B" @if($anggota_ekstrakulikuler->nilai == 'B') selected @endif>B</option>
                                    <option value="C" @if($anggota_ekstrakulikuler->nilai == 'C') selected @endif>C</option>
                                    <option value="D" @if($anggota_ekstrakulikuler->nilai == 'D') selected @endif>D</option>
                                    @endif
                                  </select>
                                </td>
                                <td>
                                  <textarea class="form-control" id="deskripsiNilai" name="deskripsi[]" rows="2" minlength="30" maxlength="200" required oninvalid="this.setCustomValidity('Deskripsi harus berisi antara 20 s/d 100 karakter')" oninput="setCustomValidity('')" readonly>{{$anggota_ekstrakulikuler->deskripsi}}</textarea>
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
                  <div class="card-footer clearfix">
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                    <a href="{{ route('nilaiekstraadmin.index') }}" class="btn btn-default float-right me-2">Batal</a>
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

@push('cus')
  <!-- ajax -->
  <script type="text/javascript">
    $(document).ready(function() {
      $('select[name="ekstrakulikuler_id"]').on('change', function() {
        var ekstrakulikuler_id = $(this).val();
        if (ekstrakulikuler_id) {
          $.ajax({
            url: '/admin/getKelas/ekstra/' + ekstrakulikuler_id,
            type: "GET",
            dataType: "json",
            success: function(data) {
              $('select[name="kelas_id"').empty();

              $('select[name="kelas_id"]').append(
                '<option value="">-- Pilih Kelas --</option>'
              );

              $.each(data, function(i, data) {
                $('select[name="kelas_id"]').append(
                  '<option value="' +
                  data.id + '">' + data.nama_kelas + '</option>');
              });
            }
          });
        } else {
          $('select[name="kelas_id"').empty();
        }
      });
    });

      $(document).ready(function() {
          $('select[name="nilai[]"]').on('change', function() {
              var selectedValue = $(this).val();
              var deskripsi = $('#deskripsiNilai');
              if (selectedValue === 'A') {
                  deskripsi.val('Excellent');
              } else if (selectedValue === 'B') {
                  deskripsi.val('Good');
              } else if (selectedValue === 'C') {
                  deskripsi.val('Fair');
              } else if (selectedValue === 'D') {
                  deskripsi.val('Need Improvement');
              } else {
                  deskripsi.val('');
              }
          }).trigger('change');
      });
  </script>
@endpush

@section('footer')
  @include('layouts.main.footer')
@endsection


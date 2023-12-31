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
            <li class="breadcrumb-item "><a href="{{ route('rencanaformatif.index') }}">Rencana Nilai Keterampilan</a></li>
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
              <h3 class="card-title"><i class="fas fa-list-alt"></i> {{$title}}</h3>
            </div>

            <div class="card-body">
              <div class="callout callout-info">
                <div class="form-group row">
                  <label for="pembelajaran_id" class="col-sm-2 col-form-label">Mata Pelajaran</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{$pembelajaran->mapel->nama_mapel}} {{$pembelajaran->kelas->nama_kelas}}" readonly>
                  </div>
                </div>
              </div>

              <div class="text-right mb-3">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
                    <i class="fas fa-plus fa-sm"></i> Tambah Data
                  </button>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead class="bg-primary">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Capaian Pembelajaran</th>
                      <th class="text-center">Kode Penilaian</th>
                      <th class="text-center">Bobot</th>
                      <th class="text-center">Kelompok/Teknik Penilaian</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 0; ?>
                    @foreach($data_rencana_penilaian as $rencana_penilaian)
                    <?php $no++; ?>
                    <tr>
                      <td class="text-center">{{$no}}</td>
                      <td><b>{{$rencana_penilaian->capaian_pembelajaran->kode_cp}}</b> {{$rencana_penilaian->capaian_pembelajaran->ringkasan_cp}}</td>
                      <td class="text-center">{{$rencana_penilaian->kode_penilaian}}</td>
                      <td class="text-center">{{$rencana_penilaian->bobot_teknik_penilaian}}</td>
                      <td class="text-center">
                        @if($rencana_penilaian->teknik_penilaian == 1)
                        Praktik
                        @elseif($rencana_penilaian->teknik_penilaian == 2)
                        Projek
                        @elseif($rencana_penilaian->teknik_penilaian == 3)
                        Produk
                        @elseif($rencana_penilaian->teknik_penilaian == 4)
                        Teknik 1
                        @elseif($rencana_penilaian->teknik_penilaian == 5)
                        Teknik 2
                        @endif
                      </td>
                      <td class="text-center">
                        <form action="{{ route('rencanaformatif.destroy', $rencana_penilaian->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mt-1" onclick="return confirm('Hapus {{$rencana_penilaian->kode_penilaian}} {{$title}} ?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>

                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-edit{{$rencana_penilaian->id}}">
                              <i class="fas fa-pencil-alt"></i>
                            </button>
                        </form>
                      </td>
                    </tr>

                    @foreach($data_rencana_penilaian_tambah as $penilaian)
                    <!-- Modal tambah  -->
                      <div class="modal fade" id="modal-tambah">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Tambah {{$title}}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('rencanaformatif.create') }}" method="GET">
                                @csrf
                                <div class="form-group row">
                                  <label for="pembelajaran_id" class="col-sm-3 col-form-label">Mata Pelajaran</label>
                                  <div class="col-sm-9">
                                    <select class="form-control" name="pembelajaran_id" style="width: 100%;" aria-readonly="true">
                                      <option value="{{$penilaian->id}}" selected>{{$penilaian->mapel->nama_mapel}} {{$penilaian->kelas->nama_kelas}}</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="jumlah_penilaian" class="col-sm-3 col-form-label">Jumlah Penilaian</label>
                                  <div class="col-sm-9">
                                    <select class="form-control select2" name="jumlah_penilaian" style="width: 100%;" required onchange="this.form.submit();">
                                      <option value="">-- Pilih Jumlah Penilaian --</option>
                                      @for ($i = 1; $i <= 20; $i++) <option value="{{$i}}">{{$i}}</option> @endfor
                                    </select>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- End Modal tambah -->

                    <!-- Modal edit  -->
                      <div class="modal fade" id="modal-edit{{$rencana_penilaian->id}}">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Edit {{$title}}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('rencanaformatif.update', $rencana_penilaian->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                  <div class="form-group row">
                                    <label for="jumlah_penilaian" class="col-sm-3 col-form-label">Kode Penilaian</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="kode_penilaian" value="{{$rencana_penilaian->kode_penilaian}}" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')">
                                    </div>
                                  </div>  
                                  <div class="form-group row">
                                    <label for="bobot" class="col-sm-3 col-form-label">Bobot</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control" name="bobot_teknik_penilaian" value="{{$rencana_penilaian->bobot_teknik_penilaian}}" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')">
                                    </td>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="jumlah_penilaian" class="col-sm-3 col-form-label">Teknik Penilaian</label>
                                    <div class="col-sm-9">
                                    <select class="form-control" name="teknik_penilaian" style="width: 100%;" required oninvalid="this.setCustomValidity('silakan pilih item dalam daftar')" oninput="setCustomValidity('')">
                                      <option value="">-- Teknik Penilaian --</option>
                                      <option value="1" @if ($rencana_penilaian->teknik_penilaian == 1) selected @endif>Praktik</option>
                                      <option value="2" @if ($rencana_penilaian->teknik_penilaian == 2) selected @endif>Projek</option>
                                      <option value="3" @if ($rencana_penilaian->teknik_penilaian == 3) selected @endif>Produk</option>
                                      <option value="4" @if ($rencana_penilaian->teknik_penilaian == 4) selected @endif>Teknik 1</option>
                                      <option value="5" @if ($rencana_penilaian->teknik_penilaian == 5) selected @endif>Teknik 2</option>
                                    </select>
                                    </td>
                                  </div>

                              </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- End Modal edit -->
                    @endforeach

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
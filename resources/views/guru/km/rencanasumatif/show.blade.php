@extends('layouts.main.header')

@section('sidebar')
  @include('layouts.sidebar.guru')
@endsection

@section('content')
  <!-- ============================================================== -->
  <!-- Page wrapper  -->
  <!-- ============================================================== -->
  <div class="page-wrapper">
      @include('layouts.partials.breadcrumbs._breadcrumbs-item', [
        'breadcrumbs' => [
          [
            'title' => 'Dashboard', 
            'url' => route('dashboard'),
            'active' => true
          ],
          [
            'title' => 'Rencana Sumatif',
            'url' => route('rencanasumatif.index'),
            'active' => false
          ]
        ],
      ])
      <!-- ============================================================== -->
      <!-- Container fluid  -->
      <!-- ============================================================== -->
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

              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead class="bg-primary">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Kode Penilaian</th>
                      <th class="text-center">Bobot</th>
                      <th class="text-center">Kelompok/Teknik Penilaian</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @if(empty(count($data_rencana_penilaian)))
                        <tr>
                            <td class="text-center" colspan="5">Data tidak tersedia</td>
                        </tr>
                    @else
                      <?php $no = 0; ?>
                      @foreach($data_rencana_penilaian as $rencana_penilaian)
                      <?php $no++; ?>
                      <tr>
                        <td class="text-center">{{$no}}</td>
                        <td class="text-center">{{$rencana_penilaian->kode_penilaian}}</td>
                        <td class="text-center">{{$rencana_penilaian->bobot_teknik_penilaian}}</td>
                        <td class="text-center">
                          @if($rencana_penilaian->teknik_penilaian == 1)
                          Tes Tulis
                          @elseif($rencana_penilaian->teknik_penilaian == 2)
                          Tes Lisan
                          @elseif($rencana_penilaian->teknik_penilaian == 3)
                          Penugasan
                          @endif
                        </td>
                        <td class="text-center">
                          <button type="button" class="btn btn-sm btn-warning mt-1" data-bs-toggle="modal" data-bs-target="#modal-edit{{$rencana_penilaian->id}}">
                            <i class="fas fa-pencil-alt"></i>
                          </button>
                        </td>
                      </tr>

                      @foreach($data_rencana_penilaian_tambah as $penilaian)
                        <!-- Modal edit  -->
                          <div class="modal fade" id="modal-edit{{$rencana_penilaian->id}}">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Edit {{$title}}</h5>
                                  
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="{{ route('guru.rencanasumatif.update', $rencana_penilaian->id) }}" method="POST">
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
                                        <option value="1" @if ($rencana_penilaian->teknik_penilaian == 1) selected @endif>Tes Tulis</option>
                                        <option value="2" @if ($rencana_penilaian->teknik_penilaian == 2) selected @endif>Tes Lisan</option>
                                        <option value="3" @if ($rencana_penilaian->teknik_penilaian == 3) selected @endif>Penugasan</option>
                                      </select>
                                      </td>
                                      </div>
                                    </div>
                                    <div class="text-end">
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
          <!-- ============================================================== -->
      <!-- End Container fluid  -->
      <!-- ============================================================== -->
    </div>
@endsection

@section('footer')
  @include('layouts.main.footer')
@endsection
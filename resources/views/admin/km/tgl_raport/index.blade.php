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
              <h3 class="card-title"><i class="fas fa-calendar-week"></i> {{$title}}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>

            <!-- Modal tambah  -->
            <div class="modal fade" id="modal-tambah">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Input {{$title}}</h5>
                    
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </button>
                  </div>
                  <form action="{{ route('tglraportkm.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                      <div class="form-group row">
                        <label for="tapel_id" class="col-sm-3 col-form-label">Tahun Pelajaran</label>
                        <div class="col-sm-9">
                          <select class="form-control select2" name="tapel_id" id="tapel_id">
                            @foreach ($data_tapel as $x)
                                <option value="{{ $x->id }}" data-tapel="{{ $x->id }}" data-semester="{{ $x->semester->id }}">{{ $x->tahun_pelajaran }} | Semester {{ $x->semester->semester }}</option>
                            @endforeach
                        </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="tempat_penerbitan" class="col-sm-3 col-form-label">Tempat Penerbitan</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="tempat_penerbitan">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="tanggal_pembagian" class="col-sm-3 col-form-label">Tanggal Pembagian</label>
                        <div class="col-sm-9">
                          <input type="date" class="form-control" name="tanggal_pembagian">
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                      <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End Modal tambah -->

            <div class="card-body">
              <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-valign-middle table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Semester</th>
                      <th>Tempat</th>
                      <th>Tanggal Pembagian Raport</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 0; ?>
                    @foreach($data_tgl_raport as $tgl_raport)
                    <?php $no++; ?>
                    <tr>
                      <td>{{$no}}</td>
                      <td>{{$tgl_raport->tapel->tahun_pelajaran}}
                        @if($tgl_raport->tapel->semester_id == 1)
                        Ganjil
                        @else
                        Genap
                        @endif
                      </td>
                      <td>{{$tgl_raport->tempat_penerbitan}}</td>
                      <td>{{ date('d-M-Y', strtotime($tgl_raport->tanggal_pembagian))}}</td>
                      <td>
                        <form action="{{ route('tglraportkm.destroy', $tgl_raport->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-warning btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#modal-edit{{$tgl_raport->id}}">
                            <i class="fas fa-pencil-alt"></i>
                          </button>
                          <button type="submit" class="btn btn-danger btn-sm mt-1" onclick="return confirm('Hapus {{$title}} ?')">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </form>
                      </td>
                    </tr>

                    <!-- Modal edit  -->
                    <div class="modal fade" id="modal-edit{{$tgl_raport->id}}">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Edit {{$title}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                          </div>
                          <form action="{{ route('tglraportkm.update', $tgl_raport->id) }}" method="POST">
                            {{ method_field('PATCH') }}
                            @csrf
                            <div class="modal-body">
                              <div class="form-group row">
                                <label for="tapel_id" class="col-sm-3 col-form-label">Tahun Pelajaran</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="tapel_id" value="{{$tgl_raport->tapel->tahun_pelajaran}} {{$tgl_raport->tapel->semester_id}}" readonly>
                                  <input type="hidden" class="form-control" name="semester_id" value="{{$tgl_raport->tapel->semester_id}}" readonly>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="tempat_penerbitan" class="col-sm-3 col-form-label">Tempat Penerbitan</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="tempat_penerbitan" name="tempat_penerbitan" value="{{$tgl_raport->tempat_penerbitan}}">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="tanggal_pembagian" class="col-sm-3 col-form-label">Tanggal Pembagian</label>
                                <div class="col-sm-9">
                                  <input type="date" class="form-control" id="tanggal_pembagian" name="tanggal_pembagian" value="{{$tgl_raport->tanggal_pembagian->format('Y-m-d')}}">
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-end">
                              <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- End Modal edit -->
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
          <!-- ============================================================== -->
      <!-- End Container fluid  -->
      <!-- ============================================================== -->
    </div>
@endsection

@section('footer')
  @include('layouts.main.footer')
@endsection
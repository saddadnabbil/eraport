@extends('layouts.main.header')
@section('sidebar')
  @include('layouts.sidebar.admin')
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

      {{-- data table --}}
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
                    <h5 class="modal-title">Tambah {{$title}}</h5>
                    
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </button>
                  </div>
                  <form action="{{ route('tingkatan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                      <div class="form-group row">
                        <label for="tahun_pelajaran" class="col-sm-3 col-form-label">Nama Tingkatan</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="nama_tingkatan" name="nama_tingkatan" placeholder="Nama Tingkatan" value="{{old('nama_tingkatan')}}">
                        </div>
                      </div>
                      <div class="form-group row">
                         <label for="term_id" class="col-sm-3 col-form-label">Term</label>
                         <div class="col-sm-9">
                           <select class="form-control select2" name="term_id" id="term_id">
                            <option value="1">1</option>
                            <option value="2">2</option>
                           </select>
                         </div>
                      </div>
                      <div class="form-group row">
                        <label for="semester_id" class="col-sm-3 col-form-label">Semester</label>
                        <div class="col-sm-9">
                          <select class="form-control select2" name="semester_id" id="semester_id">
                           <option value="1">1</option>
                           <option value="2">2</option>
                          </select>
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

                <table id="example1" class="table table-striped table-valign-middle table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Tingkatan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 0; ?>
                    @foreach($data_tingkatan as $tingkatan)
                        <?php $no++; ?>
                        <td>{{$no}}</td>
                        <td>{{ $tingkatan->nama_tingkatan }}</td>
                        <td>
                            <form action="{{ route('tingkatan.destroy', $tingkatan->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-warning btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#modal-edit{{$tingkatan->id}}">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button type="submit" class="btn btn-danger btn-sm mt-1" onclick="return confirm('Hapus {{$title}} ?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                        </tr>


                    <!-- Modal edit  -->
                    <div class="modal fade" id="modal-edit{{$tingkatan->id}}">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title">Edit {{$title}}</h5>
                            
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            <form action="{{ route('tingkatan.update', $tingkatan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="term_id" value="{{ $tingkatan->term_id }}">
                            <input type="hidden" name="semester_id" value="{{ $tingkatan->semester_id }}">
                            <div class="modal-body">
                                <div class="form-group row">
                                <label for="tahun_pelajaran" class="col-sm-3 col-form-label">Nama Tingkatan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_tingkatan" name="nama_tingkatan" placeholder="Nama Tingkatan" value="{{$tingkatan->nama_tingkatan}}"">
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
    <!--/. container-fluid -->
  </section>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->  

@include('layouts.main.footer')

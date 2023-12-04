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

      {{-- data table --}}
      <!-- ./row -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-calendar-week"></i> {{$title}}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool btn-sm" data-toggle="modal" data-target="#modal-tambah">
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="{{ route('jurusan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                      <div class="form-group row">
                        <label for="tahun_pelajaran" class="col-sm-3 col-form-label">Nama Jurusan</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" placeholder="Nama Jurusan" value="{{old('nama_jurusan')}}">
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
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
                      <th>Nama Jurusan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 0; ?>
                    @foreach($data_jurusan as $jurusan)
                        <?php $no++; ?>
                        <td>{{$no}}</td>
                        <td>{{ $jurusan->nama_jurusan }}</td>
                        <td>
                            <form action="{{ route('jurusan.destroy', $jurusan->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-warning btn-sm mt-1" data-toggle="modal" data-target="#modal-edit{{$jurusan->id}}">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button type="submit" class="btn btn-danger btn-sm mt-1" onclick="return confirm('Hapus {{$title}} ?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                        </tr>

                        <!-- Modal edit  -->
                        <div class="modal fade" id="modal-edit{{$jurusan->id}}">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">Edit {{$title}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <form action="{{ route('jurusan.update', $jurusan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group row">
                                    <label for="tahun_pelajaran" class="col-sm-3 col-form-label">Nama Jurusan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" placeholder="Nama Jurusan" value="{{$jurusan->nama_jurusan}}">
                                    </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-end">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
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

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

      {{-- select year --}}
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Select Tahun Pelajaran</h3>

            </div>
            <div class="card-body">
              <form action="{{ route('tapel.setAcademicYear') }}" method="POST">
                  @csrf
                  <div class="form-group">
                      <select class="custom-select" name="select_tapel_id">
                        <option selected>{{ $tapel_id }}</option>
                        @foreach($data_tapel as $tapel)
                          @if($tapel->tahun_pelajaran != $tapel_id)
                            <option value="{{ $tapel->id }}">{{ $tapel->tahun_pelajaran }}</option>
                          @endif
                        @endforeach
                      </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
            </div>
          </div>        
        </div>
      </div>

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
                  <form action="{{ route('tapel.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                      <div class="form-group row">
                        <label for="tahun_pelajaran" class="col-sm-3 col-form-label">Tahun Pelajaran</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" placeholder="Tahun Pelajaran" value="{{old('tahun_pelajaran')}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="semester" class="col-sm-3 col-form-label">Semester</label>
                        <div class="col-sm-9 pt-1">
                          <label class="radio-inline mr-3"><input type="radio" name="semester" value="1" @if (old('semester')=='1' ) checked @endif required> Semester Ganjil</label>
                          <label class="radio-inline mr-3"><input type="radio" name="semester" value="2" @if (old('semester')=='2' ) checked @endif required> Semester Genap</label>
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
                      <th>Tahun Pelajaran</th>
                      <th>Semester</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 0; ?>
                    @foreach($data_tapel as $tapel)
                    <?php $no++; ?>
                    <tr>
                      <td>{{$no}}</td>
                      <td>{{$tapel->tahun_pelajaran}}</td>
                      <td>
                        @if($tapel->semester == 1)
                        Semester Ganjil
                        @else
                        Semester Genap
                        @endif
                      </td>
                      <td>
                        <form action="{{ route('tapel.destroy', $tapel->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-warning btn-sm mt-1" data-toggle="modal" data-target="#modal-edit{{$tapel->id}}">
                            <i class="fas fa-pencil-alt"></i>
                          </button>
                          <button type="submit" class="btn btn-danger btn-sm mt-1" onclick="return confirm('Hapus {{$title}} ?')">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </form>
                      </td>
                    </tr>

                  <!-- Modal edit  -->
                  <div class="modal fade" id="modal-edit{{$tapel->id}}">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Edit {{$title}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <form action="{{ route('tapel.update', $tapel->id) }}" method="POST">
                          @csrf
                          <div class="modal-body">
                            <div class="form-group row">
                              <label for="tahun_pelajaran" class="col-sm-3 col-form-label">Tahun Pelajaran</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" placeholder="Tahun Pelajaran" value="{{$tapel->tahun_pelajaran}}">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="semester" class="col-sm-3 col-form-label">Semester</label>
                              <div class="col-sm-9 pt-1">
                                <label class="radio-inline mr-3"><input type="radio" name="semester"  value="1" @if ($tapel->semester=='1' ) checked @endif required> Semester Ganjil</label>
                                <label class="radio-inline mr-3"><input type="radio" name="semester" value="2" @if ($tapel->semester=='2' ) checked @endif required> Semester Genap</label>
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
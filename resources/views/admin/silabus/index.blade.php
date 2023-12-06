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
                    <h3 class="card-title"><i class="fas fa-calendar-week"></i> {{$title}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal" data-target="#modal-tambah">
                        <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    </div>

                    <!-- Modal tambah  -->
                    <div class="modal fade" id="modal-tambah">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah {{$title}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('silabusadmin.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="kelas_id" class="required">Class</label>
                                    <select id="kelas_id" name="kelas_id" class="form-control ">
                                    <option value="">-- Select Class Name --</option>
                                    @foreach ($kelas as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
                                    @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="mapel_id" class="required">Subject Name</label>
                                    <select id="mapel_id" name="mapel_id" class="select2bs4 form-control">
                                        <option value="">-- Select Subject Name --</option>
                                        @foreach ($mapel as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama_mapel }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="k_tigabelas">Input File K13</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="k_tigabelas" class="custom-file-input" id="k_tigabelas">
                                                <label class="custom-file-label" for="k_tigabelas">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="cambridge">Input File Cambridge</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="cambridge" class="custom-file-input" id="cambridge">
                                                <label class="custom-file-label" for="cambridge">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="col-sm-6">
                                            <label for="edexcel">Input File Edexcel</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="edexcel" class="custom-file-input" id="edexcel">
                                                    <label class="custom-file-label" for="edexcel">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                    <label for="book_indo_siswa">Input File Book Indo Student</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="book_indo_siswa" class="custom-file-input" id="book_indo_siswa">
                                            <label class="custom-file-label" for="book_indo_siswa">Choose file</label>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <label for="book_english_siswa">Input File Book English Student</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="book_english_siswa" class="custom-file-input" id="book_english_siswa">
                                            <label class="custom-file-label" for="book_english_siswa">Choose file</label>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="book_indo_guru">Input File Book Indo Teacher</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="book_indo_guru" class="custom-file-input" id="book_indo_guru">
                                                    <label class="custom-file-label" for="book_indo_guru">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="book_english_guru">Input File Book English Teacher</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="book_english_guru" class="custom-file-input" id="book_english_guru">
                                                    <label class="custom-file-label" for="book_english_guru">Choose file</label>
                                                </div>
                                            </div>
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
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Silabus</th>
                            <th>Buku Siswa</th>
                            <th>Buku Guru</th>
                            <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            @foreach($data_silabus as $silabus)
                                <?php $no++; ?>
                                <td>{{$no}}</td>
                                <td>{{ $silabus->mapel->nama_mapel }}</td>
                                <td>{{ $silabus->kelas->nama_kelas }}</td>
                                <td>
                                    <a href="{{ route('download.silabus', ['file' => $silabus->k_tigabelas]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; K13</a>
                                    <a href="{{ route('download.silabus', ['file' => $silabus->cambridge]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; Cambridge</a>
                                    <a href="{{ route('download.silabus', ['file' => $silabus->edexcel]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; Edexcel</a>
                                </td>
                                <td>
                                    <a href="{{ route('download.silabus', ['file' => $silabus->book_indo_siswa]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; Indonesian</a>
                                    <a href="{{ route('download.silabus', ['file' => $silabus->book_english_siswa]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; English</a>
                                </td>
                                <td>
                                    <a href="{{ route('download.silabus', ['file' => $silabus->book_indo_guru]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; Indonesian</a>
                                    <a href="{{ route('download.silabus', ['file' => $silabus->book_english_guru]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; English</a>
                                    {{-- <a href="{{ Storage::download('silabus/'.$silabus->book_indo_guru)}}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; Indonesian</a>
                                    <a href="{{ Storage::download('silabus/'.$silabus->book_english_guru)}}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; English</a> --}}
                                </td>
                                <td>
                                    <form action="{{ route('silabusadmin.destroy', $silabus->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-warning btn-sm mt-1" data-toggle="modal" data-target="#modal-edit{{$silabus->id}}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button type="submit" class="btn btn-danger btn-sm mt-1" onclick="return confirm('Hapus {{$title}} ?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                                </tr> 


                             <!-- Modal edit  -->
                            <div class="modal fade" id="modal-edit{{$silabus->id}}">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Edit {{$title}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="{{ route('silabusadmin.update', $silabus->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="kelas_id" class="required">Class</label>
                                                    <select id="kelas_id" name="kelas_id" class="form-control" required>
                                                    <option value="">-- Select Class Name --</option>
                                                    @foreach ($kelas as $data)
                                                        <option value="{{ $data->id }}" @if ($silabus->kelas_id == $data->id) selected @endif>{{ $data->nama_kelas }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="mapel_id" class="required">Subject Name</label>
                                                    <select id="mapel_id" name="mapel_id" class="select2bs4 form-control " required>
                                                        <option value="">-- Select Subject Name --</option>
                                                        @foreach ($mapel as $data)
                                                        <option value="{{ $data->id }}" @if ($silabus->mapel_id == $data->id) selected @endif>{{ $data->nama_mapel }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <label for="k_tigabelas">Input File K13</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" name="k_tigabelas" class="custom-file-input" id="k_tigabelas">
                                                                <label class="custom-file-label" for="k_tigabelas">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="cambridge">Input File Cambridge</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" name="cambridge" class="custom-file-input" id="cambridge">
                                                                <label class="custom-file-label" for="cambridge">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="col-sm-6">
                                                            <label for="edexcel">Input File Edexcel</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" name="edexcel" class="custom-file-input" id="edexcel">
                                                                    <label class="custom-file-label" for="edexcel">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                    <label for="book_indo_siswa">Input File Book Indo Student</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="book_indo_siswa" class="custom-file-input" id="book_indo_siswa">
                                                            <label class="custom-file-label" for="book_indo_siswa">Choose file</label>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                    <label for="book_english_siswa">Input File Book English Student</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="book_english_siswa" class="custom-file-input" id="book_english_siswa">
                                                            <label class="custom-file-label" for="book_english_siswa">Choose file</label>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                        <div class="col-sm-6">
                                                            <label for="book_indo_guru">Input File Book Indo Teacher</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" name="book_indo_guru" class="custom-file-input " id="book_indo_guru">
                                                                    <label class="custom-file-label" for="book_indo_guru">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="book_english_guru">Input File Book English Teacher</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" name="book_english_guru" class="custom-file-input " id="book_english_guru">
                                                                    <label class="custom-file-label" for="book_english_guru">Choose file</label>
                                                                </div>
                                                            </div>
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
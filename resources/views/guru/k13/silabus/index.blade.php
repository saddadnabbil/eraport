@include('layouts.main.header')
@include('layouts.sidebar.guru')

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
                    <form action="{{ route('guru.silabus.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="pembelajaran_id" id="pembelajaran_id">
                            <div class="form-group">
                                <label for="mapel_id">Subject Name</label>
                                <select class="form-control select2" name="mapel_id" id="mapel_id" style="width: 100%;" required>
                                    <option value="">-- Select Subject Name -- </option>
                                    @foreach($mapel as $data)
                                    <option value="{{$data->id}}"> {{$data->nama_mapel}}</option>
                                    @endforeach
                                </select> 
                            </div>
                            <div class="form-group">
                                <label for="kelas_id">Class Name</label>
                                <select class="form-control select2" name="kelas_id" id="kelas_id" style="width: 100%;" required>
                                <!--  -->
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
                            @if (!empty($kelas))
                                @foreach ($kelas as $data)
                                    @if ($data->id == $silabus->kelas->id)
                                        <?php $no++; ?>
                                        <td>{{$no}}</td>
                                        <td>{{ $silabus->mapel->nama_mapel }}</td>
                                        <td>{{ $silabus->kelas->nama_kelas }}</td>
                                        <td>
                                            @if (isset($silabus->k_tigabelas))
                                                <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->k_tigabelas]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; K13</a>
                                            @endif
                                            @if (isset($silabus->cambridge))
                                                <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->cambridge]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; Cambridge</a>
                                            @endif
                                            @if (isset($silabus->edexcel))
                                                <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->edexcel]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; Edexcel</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($silabus->book_indo_siswa))
                                                <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->book_indo_siswa]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; Indonesian</a>
                                            @endif
                                            @if (isset($silabus->book_english_siswa))
                                                <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->book_english_siswa]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; English</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($silabus->book_indo_guru))
                                                <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->book_indo_guru]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; Indonesian</a>
                                            @endif
                                            @if (isset($silabus->book_english_guru))
                                                <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->book_english_guru]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-download"></i> &nbsp; English</a>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('guru.silabus.destroy', $silabus->id) }}" method="POST">
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
                                                    <form action="{{ route('guru.silabus.update', $silabus->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <input type="hidden" name="pembelajaran_id" id="pembelajaran_id">
                                                            <div class="form-group">
                                                                <label for="mapel_id">Subject Name</label>
                                                                <select class="form-control select2" name="mapel_id" id="mapel_id" style="width: 100%;" required>
                                                                    <option value="">-- Select Subject Name -- </option>
                                                                    @foreach($mapel as $data)
                                                                    <option value="{{$data->id}}"> {{$data->nama_mapel}}</option>
                                                                    @endforeach
                                                                </select> 
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kelas_id">Class Name</label>
                                                                <select class="form-control select2" name="kelas_id" id="kelas_id" style="width: 100%;" required>
                                                                <!--  -->
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
                                    @endif
                                @endforeach
                            @endif
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

<!-- ajax get class and mapel -->
<script type="text/javascript">
    $(document).ready(function() {
      $('select[name="mapel_id"]').on('change', function() {
        var mapel_id = $(this).val();
        if (mapel_id) {
          $.ajax({
            url: '/guru/getKelas/ajax/' + mapel_id,
            type: "GET",
            dataType: "json",
            success: function(data) {
              $('select[name="kelas_id"').empty();
  
              $('select[name="kelas_id"]').append(
                '<option value="">-- Select Class Name --</option>'
              );
  
              $.each(data, function(i, data) {
                $('select[name="kelas_id"]').append(
                  '<option value="' +
                  data.kelas_id + '">' + data.nama_kelas + '</option>');
              });
            }
          });
        } else {
          $('select[name="kelas_id"').empty();
        }
      });
    });
  </script>

<script>
    $(document).ready(function () {
        // Event listener untuk perubahan pada #kelas_id
        $('#kelas_id').on('change', function () {
            // Panggil fungsi untuk mengupdate nilai pembelajaran_id
            updatePembelajaranId();
        });

        // Fungsi untuk mengupdate nilai pembelajaran_id
        function updatePembelajaranId() {
            var mapelId = $('#mapel_id').val();
            var kelasId = $('#kelas_id').val();

            // Hanya panggil AJAX jika kelasId tidak kosong
            if (kelasId) {
                $.ajax({
                    url: '{{ route('guru.get.pembelajaran.id') }}',
                    method: 'GET',
                    data: {
                        mapel_id: mapelId,
                        kelas_id: kelasId
                    },
                    success: function (response) {
                        // Setel nilai pembelajaran_id sesuai respons
                        $('#pembelajaran_id').val(response.pembelajaran_id);
                    },
                    error: function (error) {
                        console.error('Error fetching pembelajaran_id:', error);
                    }
                });
            }
        }

        // Panggil fungsi saat halaman dimuat untuk menginisialisasi nilai pembelajaran_id
        updatePembelajaranId();
    });
</script>

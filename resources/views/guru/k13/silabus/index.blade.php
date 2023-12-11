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
                                <input type="hidden" name="pembelajaran_id" id="pembelajaran_id_tambah">

                                <div class="form-group">
                                    <label for="mapel_id_tambah">Subject Name</label>
                                    <select class="form-control select2" name="mapel_id" id="mapel_id_tambah" style="width: 100%;" required>
                                        <option value="">-- Select Subject Name -- </option>
                                        @foreach($mapel as $data)
                                        <option value="{{$data->id}}"> {{$data->nama_mapel}}</option>
                                        @endforeach
                                    </select> 
                                </div>
                                <div class="form-group">
                                    <label for="kelas_id_tambah">Class</label>
                                    <select class="form-control select2" name="kelas_id" id="kelas_id_tambah" style="width: 100%;" required>
                                    <!--  -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="k_tigabelas">Input File K13</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="k_tigabelas" class="custom-file-input" id="k_tigabelas">
                                            <label class="custom-file-label" for="k_tigabelas">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cambridge">Input File Cambridge</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="cambridge" class="custom-file-input" id="cambridge">
                                            <label class="custom-file-label" for="cambridge">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="edexcel">Input File Edexcel</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="edexcel" class="custom-file-input" id="edexcel">
                                            <label class="custom-file-label" for="edexcel">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="book_indo_siswa">Input File Book Indo Student</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="book_indo_siswa" class="custom-file-input" id="book_indo_siswa">
                                            <label class="custom-file-label" for="book_indo_siswa">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="book_english_siswa">Input File Book English Student</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="book_english_siswa" class="custom-file-input" id="book_english_siswa">
                                            <label class="custom-file-label" for="book_english_siswa">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="book_indo_guru">Input File Book Indo Teacher</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="book_indo_guru" class="custom-file-input" id="book_indo_guru">
                                            <label class="custom-file-label" for="book_indo_guru">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="book_english_guru">Input File Book English Teacher</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="book_english_guru" class="custom-file-input" id="book_english_guru">
                                            <label class="custom-file-label" for="book_english_guru">Choose file</label>
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
                            @foreach($data_silabus as $item)
                                @foreach($item as $silabus)
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
                                                <form id="deleteForm{{$silabus->id}}" action="{{ route('guru.silabus.destroy', $silabus->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button" class="btn btn-warning btn-sm mt-1" data-toggle="modal" data-target="#modal-edit{{$silabus->id}}" data-id="{{$silabus->id}}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-danger btn-sm mt-1" onclick="confirmAndSubmit('{{$title}}', {{$silabus->id}})">
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
                                                                    <input type="hidden" name="pembelajaran_id" id="pembelajaran_id_edit{{$silabus->id}}">
                                                                    <div class="form-group">
                                                                        <label for="mapel_id_edit{{$silabus->id}}">Subject Name</label>
                                                                        <select class="form-control select2" name="mapel_id" id="mapel_id_edit{{$silabus->id}}" style="width: 100%;" required>
                                                                            <option value="">-- Select Subject Name -- </option>
                                                                            @foreach($mapel as $data)
                                                                            <option value="{{$data->id}}"> {{$data->nama_mapel}}</option>
                                                                            @endforeach
                                                                        </select> 
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="kelas_id_edit{{$silabus->id}}">Class Name</label>
                                                                        <select class="form-control select2" name="kelas_id" id="kelas_id_edit{{$silabus->id}}" style="width: 100%;" required>
                                                                        <!--  -->
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="k_tigabelas">Input File K13</label>
                                                                        @if ($silabus->k_tigabelas)
                                                                            <a href="#" class="badge badge-danger badge-sm mb-2 mr-1" onclick="deleteFile('{{$silabus->id}}', 'k_tigabelas')">
                                                                                <i class="fas fa-trash-alt"></i> &nbsp; delete k13
                                                                            </a>
                                                                            <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->k_tigabelas]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-eye"></i> &nbsp; view k13</a>
                                                                        @endif
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="k_tigabelas" class="custom-file-input" id="k_tigabelas_edit">
                                                                                <label class="custom-file-label" for="k_tigabelas">Choose file</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="cambridge">Input File Cambridge</label>
                                                                        @if ($silabus->cambridge)
                                                                            <a href="#" class="badge badge-danger badge-sm mb-2 mr-1" onclick="deleteFile('{{$silabus->id}}', 'k_tigabelas')">
                                                                                <i class="fas fa-trash-alt"></i> &nbsp; delete cambridge
                                                                            </a>
                                                                            <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->cambridge]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-eye"></i> &nbsp; view cambridge</a>
                                                                        @endif
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="cambridge" class="custom-file-input" id="cambridge_edit">
                                                                                <label class="custom-file-label" for="cambridge">Choose file</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="edexcel">Input File Edexcel</label>
                                                                        @if ($silabus->edexcel)
                                                                            <a href="#" class="badge badge-danger badge-sm mb-2 mr-1" onclick="deleteFile('{{$silabus->id}}', 'k_tigabelas')">
                                                                                <i class="fas fa-trash-alt"></i> &nbsp; delete edexcel
                                                                            </a>
                                                                            <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->edexcel]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-eye"></i> &nbsp; view file edexcel</a>
                                                                        @endif
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="edexcel" class="custom-file-input" id="edexcel_edit">
                                                                                <label class="custom-file-label" for="edexcel">Choose file</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="book_indo_siswa">Input File Book Indo Student</label>
                                                                        @if ($silabus->book_indo_siswa)
                                                                            <a href="#" class="badge badge-danger badge-sm mb-2 mr-1" onclick="deleteFile('{{$silabus->id}}', 'k_tigabelas')">
                                                                                <i class="fas fa-trash-alt"></i> &nbsp; delete book_indo_siswa
                                                                            </a>
                                                                            <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->book_indo_siswa]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-eye"></i> &nbsp; view file book_indo_siswa</a>
                                                                        @endif
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="book_indo_siswa" class="custom-file-input" id="book_indo_siswa_edit">
                                                                                <label class="custom-file-label" for="book_indo_siswa">Choose file</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="book_english_siswa">Input File Book English Student</label>
                                                                        @if ($silabus->book_english_siswa)
                                                                            <a href="#" class="badge badge-danger badge-sm mb-2 mr-1" onclick="deleteFile('{{$silabus->id}}', 'k_tigabelas')">
                                                                                <i class="fas fa-trash-alt"></i> &nbsp; delete book english siswa
                                                                            </a>
                                                                            <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->book_english_siswa]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-eye"></i> &nbsp; view file book english siswa</a>
                                                                        @endif
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="book_english_siswa" class="custom-file-input" id="book_english_siswa_edit">
                                                                                <label class="custom-file-label" for="book_english_siswa">Choose file</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="book_indo_guru">Input File Book Indo Teacher</label>
                                                                        @if ($silabus->book_indo_guru)
                                                                            <a href="#" class="badge badge-danger badge-sm mb-2 mr-1" onclick="deleteFile('{{$silabus->id}}', 'book_indo_guru')">
                                                                                <i class="fas fa-trash-alt"></i> &nbsp; delete book indo guru
                                                                            </a>
                                                                            <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->book_indo_guru]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-eye"></i> &nbsp; view file book indo guru</a>
                                                                        @endif
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="book_indo_guru" class="custom-file-input " id="book_indo_guru_edit">
                                                                                <label class="custom-file-label" for="book_indo_guru">Choose file</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="book_english_guru">Input File Book English Teacher</label>
                                                                        @if ($silabus->book_english_guru)
                                                                            <a href="#" class="badge badge-danger badge-sm mb-2 mr-1" onclick="deleteFile('{{$silabus->id}}', 'k_tigabelas')">
                                                                                <i class="fas fa-trash-alt"></i> &nbsp; delete book english guru
                                                                            </a>
                                                                            <a href="{{ route('silabus.guru.pdf.view', ['filename' => $silabus->book_english_guru]) }}" class="badge badge-info badge-sm" target="_blank"><i class="nav-icon fas fa-eye"></i> &nbsp; view file book english guru</a>
                                                                        @endif
                                                                        <div class="input-group">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="book_english_guru" class="custom-file-input " id="book_english_guru_edit">
                                                                                <label class="custom-file-label" for="book_english_guru">Choose file</label>
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

<!-- ajax get class id and show class name-->
<script>
    $(document).ready(function () {

        $(document).on('change', '#kelas_id_tambah, [id^="mapel_id_tambah"]', function () {
            var id = $(this).attr('id');
            updatePembelajaranId(id);
        });

        $(document).on('change', '[id^="kelas_id_edit"], [id^="mapel_id_edit"]', function () {
            console.log('Change event triggered');
            var id = $(this).attr('id');
            updatePembelajaranId(id);
        });

        function updatePembelajaranId(id) {
            if (id.includes('edit')) {
                var numericId = id.replace(/\D/g, ''); // Extract numeric part from ID
                mapelId = $('#mapel_id_edit' + numericId).val();
                kelasId = $('#kelas_id_edit' + numericId).val();
                pembelajaranIdField = $('#pembelajaran_id_edit' + numericId);
            } else {
                mapelId = $('#mapel_id_tambah').val();
                kelasId = $('#kelas_id_tambah').val();
                pembelajaranIdField = $('#pembelajaran_id_tambah');
            }

            if (kelasId) {
                $.ajax({
                    url: "{{ route('guru.get.pembelajaran.id') }}",
                    method: 'GET',
                    data: {
                        mapel_id: mapelId,
                        kelas_id: kelasId
                    },
                    success: function (response) {
                        console.log('Response received:', response);
                        pembelajaranIdField.val(response.pembelajaran_id);
                        pembelajaranIdField.attr('placeholder', response.placeholder_value);
                    },
                    error: function (error) {
                        console.error('Error fetching pembelajaran_id:', error);
                    }
                });
            }
        }
    });
</script>

<!-- ajax get and update silabus -->
<script>
    $(document).ready(function () {
        // Event listener untuk klik tombol edit
        $('[data-target^="#modal-edit"]').on('click', function () {
            // Mendapatkan ID dari data-id atribut
            var silabusId = $(this).data('id');

            // Memanggil fungsi untuk mendapatkan data Silabus berdasarkan ID
            getSilabusData(silabusId);
        });

        // Fungsi untuk mendapatkan data Silabus berdasarkan ID menggunakan AJAX
        function getSilabusData(id) {
            $.ajax({
                url: "{{ route('guru.get.all.silabus', ':id') }}".replace(':id', id),
                method: 'GET',
                success: function (response) {
                    if (response.success) {
                var silabusData = response.data;

                // Mengatur nilai pembelajaran_id
                $('#pembelajaran_id_edit' + id).val(silabusData.pembelajaran_id);

                // Mengatur nilai mapel_id dan memilih opsi di dalam dropdown
                $('#mapel_id_edit' + id).val(silabusData.mapel_id).trigger('change');

                // Mengatur nilai kelas_id dan memilih opsi di dalam dropdown
                $('#kelas_id_edit' + id).val(silabusData.kelas_id).trigger('change');

                // Menampilkan modal setelah mengatur nilai-nilai
                $('#modal-edit' + id).modal('show');
            } else {
                console.error('Error:', response.message);
            }
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        }
    });
</script>

<!-- ajax delete spesific file silabus -->
<script>
    function deleteFile(id, fileType) { 
        Swal.fire({
            title: 'Delete File?',
            text: 'File will be deleted permanently.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel',
            timer: 5000, // 5000 milliseconds (5 seconds) delay
            timerProgressBar: true,
            allowOutsideClick: false // Prevent closing the modal by clicking outside
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an AJAX request to the server to delete the file
                fetch(`{{ route('guru.silabus.destroyFile', ['id' => '__id__', 'fileType' => '__fileType__']) }}`
                    .replace('__id__', id)
                    .replace('__fileType__', fileType), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Use SweetAlert2 to display a success toast
                        Swal.fire({
                            icon: 'success',
                            title: 'File dihapus!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // You may want to reload the page or update the UI as needed
                        location.reload();
                    } else {
                        // Use SweetAlert2 to display an error toast
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal menghapus file!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Use SweetAlert2 to display an error toast
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            }
        });
    }
</script>

<!-- sweetalert confirm delete -->
<script>
    function confirmAndSubmit(title, id) {
        Swal.fire({
            title: 'Delete ' + title + ' ?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, submit the form
                document.getElementById('deleteForm' + id).submit();
            }
        });
    }
</script>

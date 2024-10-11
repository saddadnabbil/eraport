@extends('layouts.main.header')

@section('sidebar')
    @include('layouts.sidebar.admin')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            $dashboard = route('admin.dashboard');
        @endphp
        @include('layouts.partials.breadcrumbs._breadcrumbs-item', [
            'titleBreadCrumb' => $title,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => $dashboard,
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => route('user.index'),
                    'active' => false,
                ],
            ],
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
                            <h3 class="card-title">{{ $title }}</h3>
                            <div class="card-tools">
                                @if ($user->getRoleNames()->first() != 'Student')
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-tambah">
                                        <i class="fas fa-plus"></i>
                                        Create
                                    </button>
                                @endif
                            </div>
                        </div>

                        @if ($user->getRoleNames()->first() != 'Student')
                            <!-- Modal tambah  -->
                            <div class="modal fade" id="modal-tambah">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah {{ $title }}</h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-hidden="true"></button>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.silabus.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" name="pembelajaran_id" id="pembelajaran_id_tambah">

                                                <div class="form-group">
                                                    <label for="mapel_id_tambah">Subject Name</label>
                                                    <select class="form-control form-select select2" name="mapel_id"
                                                        id="mapel_id_tambah" style="width: 100%;" required>
                                                        <option value="">-- Select Subject Name -- </option>
                                                        @foreach ($mapel as $data)
                                                            <option value="{{ $data->id }}"> {{ $data->nama_mapel }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kelas_id_tambah">Class</label>
                                                    <select class="form-control form-select select2" name="kelas_id"
                                                        id="kelas_id_tambah" style="width: 100%;" required>
                                                        <!--  -->
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="k_tigabelas">Input File K13</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="k_tigabelas"
                                                                class="custom-file-input form-control" id="k_tigabelas">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="cambridge">Input File Cambridge</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="cambridge"
                                                                class="custom-file-input form-control" id="cambridge">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edexcel">Input File Edexcel</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="edexcel"
                                                                class="custom-file-input form-control" id="edexcel">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="book_indo_siswa">Input File Book Indo Student</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="book_indo_siswa"
                                                                class="custom-file-input form-control" id="book_indo_siswa">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="book_english_siswa">Input File Book English Student</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="book_english_siswa"
                                                                class="custom-file-input form-control"
                                                                id="book_english_siswa">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="book_indo_guru">Input File Book Indo Teacher</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="book_indo_guru"
                                                                class="custom-file-input form-control" id="book_indo_guru">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="book_english_guru">Input File Book English Teacher</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="book_english_guru"
                                                                class="custom-file-input form-control"
                                                                id="book_english_guru">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-end">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal tambah -->
                        @endif

                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Subject</th>
                                            <th>Class</th>
                                            <th>Syllabus</th>
                                            <th>Buku Siswa</th>
                                            <th>Buku Guru</th>
                                            @if ($user->getRoleNames()->first() != 'Student')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_silabus as $item)
                                            @foreach ($item as $silabus)
                                                <?php $no++; ?>
                                                <td>{{ $no }}</td>
                                                <td>{{ $silabus->mapel->nama_mapel }}</td>
                                                <td>{{ $silabus->kelas->nama_kelas }}</td>
                                                <td>
                                                    @if (isset($silabus->k_tigabelas))
                                                        <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->k_tigabelas]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; K13</a>
                                                    @endif
                                                    @if (isset($silabus->cambridge))
                                                        <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->cambridge]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; Cambridge</a>
                                                    @endif
                                                    @if (isset($silabus->edexcel))
                                                        <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->edexcel]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; Edexcel</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($silabus->book_indo_siswa))
                                                        <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->book_indo_siswa]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; Indonesian</a>
                                                    @endif
                                                    @if (isset($silabus->book_english_siswa))
                                                        <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->book_english_siswa]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; English</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($silabus->book_indo_guru))
                                                        <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->book_indo_guru]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; Indonesian</a>
                                                    @endif
                                                    @if (isset($silabus->book_english_guru))
                                                        <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->book_english_guru]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; English</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($user->getRoleNames()->first() != 'Student')
                                                        <form id="deleteForm{{ $silabus->id }}"
                                                            action="{{ route('admin.silabus.destroy', $silabus->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="button" class="btn btn-warning btn-sm mt-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal-edit{{ $silabus->id }}"
                                                                data-id="{{ $silabus->id }}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>

                                                            <button type="button" class="btn btn-danger btn-sm mt-1"
                                                                onclick="confirmAndSubmit('{{ $title }}', {{ $silabus->id }})">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                                </tr>

                                                @if ($user->getRoleNames()->first() != 'Student')
                                                    <!-- Modal edit  -->
                                                    <div class="modal fade" id="modal-edit{{ $silabus->id }}">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit {{ $title }}</h5>

                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-hidden="true"></button>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('admin.silabus.update', $silabus->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="pembelajaran_id"
                                                                            id="pembelajaran_id_edit{{ $silabus->id }}">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="mapel_id_edit{{ $silabus->id }}">Subject
                                                                                Name</label>
                                                                            <select
                                                                                class="form-control form-select select2"
                                                                                name="mapel_id"
                                                                                id="mapel_id_edit{{ $silabus->id }}"
                                                                                style="width: 100%;" required>
                                                                                <option value="">-- Select Subject
                                                                                    Name
                                                                                    -- </option>
                                                                                @foreach ($mapel as $data)
                                                                                    <option value="{{ $data->id }}">
                                                                                        {{ $data->nama_mapel }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="kelas_id_edit{{ $silabus->id }}">Class
                                                                                Name</label>
                                                                            <select
                                                                                class="form-control form-select select2"
                                                                                name="kelas_id"
                                                                                id="kelas_id_edit{{ $silabus->id }}"
                                                                                style="width: 100%;" required>
                                                                                <!--  -->
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="k_tigabelas">Input File K13</label>
                                                                            @if ($silabus->k_tigabelas)
                                                                                <a href="#"
                                                                                    class="badge bg-danger badge-sm mb-2 me-1"
                                                                                    onclick="deleteFile('{{ $silabus->id }}', 'k_tigabelas')">
                                                                                    <i class="fas fa-trash-alt"></i> &nbsp;
                                                                                    delete k13
                                                                                </a>
                                                                                <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->k_tigabelas]) }}"
                                                                                    class="badge bg-info badge-sm"
                                                                                    target="_blank"><i
                                                                                        class="nav-icon fas fa-eye"></i>
                                                                                    &nbsp;
                                                                                    view k13</a>
                                                                            @endif
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file"
                                                                                        name="k_tigabelas"
                                                                                        class="custom-file-input form-control"
                                                                                        id="k_tigabelas_edit">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="cambridge">Input File
                                                                                Cambridge</label>
                                                                            @if ($silabus->cambridge)
                                                                                <a href="#"
                                                                                    class="badge bg-danger badge-sm mb-2 me-1"
                                                                                    onclick="deleteFile('{{ $silabus->id }}', 'k_tigabelas')">
                                                                                    <i class="fas fa-trash-alt"></i> &nbsp;
                                                                                    delete cambridge
                                                                                </a>
                                                                                <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->cambridge]) }}"
                                                                                    class="badge bg-info badge-sm"
                                                                                    target="_blank"><i
                                                                                        class="nav-icon fas fa-eye"></i>
                                                                                    &nbsp;
                                                                                    view cambridge</a>
                                                                            @endif
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file" name="cambridge"
                                                                                        class="custom-file-input form-control"
                                                                                        id="cambridge_edit">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="edexcel">Input File
                                                                                Edexcel</label>
                                                                            @if ($silabus->edexcel)
                                                                                <a href="#"
                                                                                    class="badge bg-danger badge-sm mb-2 me-1"
                                                                                    onclick="deleteFile('{{ $silabus->id }}', 'k_tigabelas')">
                                                                                    <i class="fas fa-trash-alt"></i> &nbsp;
                                                                                    delete edexcel
                                                                                </a>
                                                                                <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->edexcel]) }}"
                                                                                    class="badge bg-info badge-sm"
                                                                                    target="_blank"><i
                                                                                        class="nav-icon fas fa-eye"></i>
                                                                                    &nbsp;
                                                                                    view file edexcel</a>
                                                                            @endif
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file" name="edexcel"
                                                                                        class="custom-file-input form-control"
                                                                                        id="edexcel_edit">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="book_indo_siswa">Input File Book
                                                                                Indo
                                                                                Student</label>
                                                                            @if ($silabus->book_indo_siswa)
                                                                                <a href="#"
                                                                                    class="badge bg-danger badge-sm mb-2 me-1"
                                                                                    onclick="deleteFile('{{ $silabus->id }}', 'k_tigabelas')">
                                                                                    <i class="fas fa-trash-alt"></i> &nbsp;
                                                                                    delete book_indo_siswa
                                                                                </a>
                                                                                <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->book_indo_siswa]) }}"
                                                                                    class="badge bg-info badge-sm"
                                                                                    target="_blank"><i
                                                                                        class="nav-icon fas fa-eye"></i>
                                                                                    &nbsp;
                                                                                    view file book_indo_siswa</a>
                                                                            @endif
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file"
                                                                                        name="book_indo_siswa"
                                                                                        class="custom-file-input form-control"
                                                                                        id="book_indo_siswa_edit">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="book_english_siswa">Input File Book
                                                                                English Student</label>
                                                                            @if ($silabus->book_english_siswa)
                                                                                <a href="#"
                                                                                    class="badge bg-danger badge-sm mb-2 me-1"
                                                                                    onclick="deleteFile('{{ $silabus->id }}', 'k_tigabelas')">
                                                                                    <i class="fas fa-trash-alt"></i> &nbsp;
                                                                                    delete book english siswa
                                                                                </a>
                                                                                <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->book_english_siswa]) }}"
                                                                                    class="badge bg-info badge-sm"
                                                                                    target="_blank"><i
                                                                                        class="nav-icon fas fa-eye"></i>
                                                                                    &nbsp;
                                                                                    view file book english siswa</a>
                                                                            @endif
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file"
                                                                                        name="book_english_siswa"
                                                                                        class="custom-file-input form-control"
                                                                                        id="book_english_siswa_edit">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="book_indo_guru">Input File Book
                                                                                Indo
                                                                                Teacher</label>
                                                                            @if ($silabus->book_indo_guru)
                                                                                <a href="#"
                                                                                    class="badge bg-danger badge-sm mb-2 me-1"
                                                                                    onclick="deleteFile('{{ $silabus->id }}', 'book_indo_guru')">
                                                                                    <i class="fas fa-trash-alt"></i> &nbsp;
                                                                                    delete book indo guru
                                                                                </a>
                                                                                <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->book_indo_guru]) }}"
                                                                                    class="badge bg-info badge-sm"
                                                                                    target="_blank"><i
                                                                                        class="nav-icon fas fa-eye"></i>
                                                                                    &nbsp;
                                                                                    view file book indo guru</a>
                                                                            @endif
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file"
                                                                                        name="book_indo_guru"
                                                                                        class="custom-file-input form-control "
                                                                                        id="book_indo_guru_edit">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="book_english_guru">Input File Book
                                                                                English Teacher</label>
                                                                            @if ($silabus->book_english_guru)
                                                                                <a href="#"
                                                                                    class="badge bg-danger badge-sm mb-2 me-1"
                                                                                    onclick="deleteFile('{{ $silabus->id }}', 'k_tigabelas')">
                                                                                    <i class="fas fa-trash-alt"></i> &nbsp;
                                                                                    delete book english guru
                                                                                </a>
                                                                                <a href="{{ route('admin.silabus.pdf.view', ['filename' => $silabus->book_english_guru]) }}"
                                                                                    class="badge bg-info badge-sm"
                                                                                    target="_blank"><i
                                                                                        class="nav-icon fas fa-eye"></i>
                                                                                    &nbsp;
                                                                                    view file book english guru</a>
                                                                            @endif
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file"
                                                                                        name="book_english_guru"
                                                                                        class="custom-file-input form-control "
                                                                                        id="book_english_guru_edit">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-end">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal edit -->
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
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
@endsection

@if ($user->getRoleNames()->first() != 'Student')
    @push('custom-scripts')
        <!-- ajax get class id and show class name-->
        <script type="text/javascript">
            $(document).ready(function() {
                $('select[name="mapel_id"]').on('change', function() {
                    var mapel_id = $(this).val();
                    if (mapel_id) {
                        $.ajax({
                            // route('admin.get.kelas') with mapel_id
                            url: '{{ route('admin.get.kelas', ':id') }}'.replace(':id', mapel_id),
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
                                        data.kelas_id + '">' + data.nama_kelas +
                                        '</option>');
                                });
                            }
                        });
                    } else {
                        $('select[name="kelas_id"').empty();
                    }
                });
            });
        </script>

        <!-- ajax get and update pembelajaran id -->
        <script>
            $(document).ready(function() {

                $(document).on('change', '#kelas_id_tambah, [id^="mapel_id_tambah"]', function() {
                    var id = $(this).attr('id');
                    updatePembelajaranId(id);
                });

                $(document).on('change', '[id^="kelas_id_edit"], [id^="mapel_id_edit"]', function() {
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
                            url: "{{ route('get.pembelajaran.id') }}",
                            method: 'GET',
                            data: {
                                mapel_id: mapelId,
                                kelas_id: kelasId
                            },
                            success: function(response) {
                                pembelajaranIdField.val(response.pembelajaran_id);
                                pembelajaranIdField.attr('placeholder', response.placeholder_value);
                            },
                            error: function(error) {
                                console.error('Error fetching pembelajaran_id:', error);
                            }
                        });
                    }
                }
            });
        </script>

        <!-- ajax get and update silabus -->
        <script>
            $(document).ready(function() {
                $('[data-bs-target^="#modal-edit"]').on('click', function() {
                    var silabusId = $(this).data('id');

                    getSilabusData(silabusId);
                });

                function getSilabusData(id) {
                    $.ajax({
                        url: "{{ route('admin.get.all.silabus', ':id') }}".replace(':id', id),
                        method: 'GET',
                        success: function(response) {
                            if (response.success) {
                                var silabusData = response.data;

                                $('#pembelajaran_id_edit' + id).val(silabusData.pembelajaran_id);

                                $('#mapel_id_edit' + id).val(silabusData.mapel_id).trigger('change');

                                $('#kelas_id_edit' + id).val(silabusData.kelas_id).trigger('change');

                                $('#modal-edit' + id).modal('show');
                            } else {
                                console.error('Error:', response.message);
                            }
                        },
                        error: function(error) {
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
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make an AJAX request to the server to delete the file
                        fetch(`{{ route('admin.silabus.destroyFile', ['id' => '__id__', 'fileType' => '__fileType__']) }}`
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

        {{-- delete data --}}
        <script>
            function confirmAndSubmit(title, id) {
                Swal.fire({
                    title: 'Delete ' + title + '?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Delete!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form for record deletion
                        document.getElementById('deleteForm' + id).submit();
                    }
                });
            }
        </script>
    @endpush
@endif
@section('footer')
    @include('layouts.main.footer')
@endsection

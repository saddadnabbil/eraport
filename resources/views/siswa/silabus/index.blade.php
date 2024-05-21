@extends('layouts.main.header')

@section('sidebar')
    @include('layouts.sidebar.siswa')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            $dashboard = route('siswa.dashboard');
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
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="zero_config" class="table table-striped table-valign-middle table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Kelas</th>
                                            <th>Silabus</th>
                                            <th>Buku Siswa</th>
                                            <th>Buku Guru</th>
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
                                                    @php
                                                        $flag = false;
                                                    @endphp

                                                    @if (isset($silabus->k_tigabelas))
                                                        <a href="{{ route('silabus.siswa.pdf.view', ['filename' => $silabus->k_tigabelas]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; K13</a>
                                                        @php
                                                            $flag = true;
                                                        @endphp
                                                    @endif

                                                    @if (isset($silabus->cambridge))
                                                        <a href="{{ route('silabus.siswa.pdf.view', ['filename' => $silabus->cambridge]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; Cambridge</a>
                                                        @php
                                                            $flag = true;
                                                        @endphp
                                                    @endif

                                                    @if (isset($silabus->edexcel))
                                                        <a href="{{ route('silabus.siswa.pdf.view', ['filename' => $silabus->edexcel]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; Edexcel</a>
                                                        @php
                                                            $flag = true;
                                                        @endphp
                                                    @endif

                                                    @if (!$flag)
                                                        Not available yet
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $flag = false;
                                                    @endphp

                                                    @if (isset($silabus->book_indo_siswa))
                                                        <a href="{{ route('silabus.siswa.pdf.view', ['filename' => $silabus->book_indo_siswa]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; Indonesian</a>
                                                        @php
                                                            $flag = true;
                                                        @endphp
                                                    @endif

                                                    @if (isset($silabus->book_english_siswa))
                                                        <a href="{{ route('silabus.siswa.pdf.view', ['filename' => $silabus->book_english_siswa]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; English</a>
                                                        @php
                                                            $flag = true;
                                                        @endphp
                                                    @endif

                                                    @if (!$flag)
                                                        Not available yet
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $flag = false;
                                                    @endphp

                                                    @if (isset($silabus->book_indo_guru))
                                                        <a href="{{ route('silabus.siswa.pdf.view', ['filename' => $silabus->book_indo_guru]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; Indonesian</a>
                                                        @php
                                                            $flag = true;
                                                        @endphp
                                                    @endif

                                                    @if (isset($silabus->book_english_guru))
                                                        <a href="{{ route('silabus.siswa.pdf.view', ['filename' => $silabus->book_english_guru]) }}"
                                                            class="badge bg-info badge-sm" target="_blank"><i
                                                                class="nav-icon fas fa-download"></i> &nbsp; English</a>
                                                        @php
                                                            $flag = true;
                                                        @endphp
                                                    @endif

                                                    @if (!$flag)
                                                        Not available yet
                                                    @endif
                                                </td>
                                                </tr>

                                                <!-- Modal edit  -->
                                                <div class="modal fade" id="modal-edit{{ $silabus->id }}">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit {{ $title }}</h5>

                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                </button>
                                                            </div>
                                                            {{-- <form action="{{ route('guru.silabus.update', $silabus->id) }}" method="POST" enctype="multipart/form-data">
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
                                                                    <input type="file" name="k_tigabelas" class="custom-file-input form-control" id="k_tigabelas">
                                                                    <label class="custom-file-label" for="k_tigabelas">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="cambridge">Input File Cambridge</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" name="cambridge" class="custom-file-input form-control" id="cambridge">
                                                                    <label class="custom-file-label" for="cambridge">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <div class="col-sm-6">
                                                                <label for="edexcel">Input File Edexcel</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" name="edexcel" class="custom-file-input form-control" id="edexcel">
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
                                                                <input type="file" name="book_indo_siswa" class="custom-file-input form-control" id="book_indo_siswa">
                                                                <label class="custom-file-label" for="book_indo_siswa">Choose file</label>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                        <label for="book_english_siswa">Input File Book English Student</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" name="book_english_siswa" class="custom-file-input form-control" id="book_english_siswa">
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
                                                                        <input type="file" name="book_indo_guru" class="custom-file-input form-control " id="book_indo_guru">
                                                                        <label class="custom-file-label" for="book_indo_guru">Choose file</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="book_english_guru">Input File Book English Teacher</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" name="book_english_guru" class="custom-file-input form-control " id="book_english_guru">
                                                                        <label class="custom-file-label" for="book_english_guru">Choose file</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-end">
                                                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form> --}}
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
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
@endsection

@section('footer')
    @include('layouts.main.footer')
@endsection

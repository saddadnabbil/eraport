@extends('layouts.main.header')

@section('sidebar')
    @include('layouts.sidebar.guru')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            if (
                $user->hasAnyRole(['Teacher', 'Curriculum']) &&
                $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])
            ) {
                $dashboard = route('guru.dashboard');
            } elseif ($user->hasAnyRole(['Student']) && $user->hasAnyPermission(['student'])) {
                $dashboard = route('siswa.dashboard');
            } else {
                $dashboard = route('admin.dashboard');
            }
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
                            <h3 class="card-title"><i class="fas fa-greater-than-equal"></i> {{ $title }}</h3>
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Tambah" class="d-inline-block" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-tambah">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div data-bs-toggle="tooltip" title="Import" class="d-inline-block" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-import">
                                        <i class="fas fa-upload"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal import  -->
                        <div class="modal fade" id="modal-import">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Import {{ $title }}</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                        </button>
                                    </div>
                                    <form name="contact-form" action="{{ route('kkmguru.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="callout callout-info">
                                                <h5>Download format import</h5>
                                                <p>Silahkan download file format import melalui tombol dibawah ini.</p>
                                                <a href="{{ route('kkmguru.format_import') }}"
                                                    class="btn btn-primary text-white" style="text-decoration:none"><i
                                                        class="fas fa-file-download"></i> Download</a>
                                            </div>
                                            <div class="form-group row pt-2">
                                                <label for="file_import" class="col-sm-2 col-form-label">File Import</label>
                                                <div class="col-sm-10">
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="custom-file-input form-control form-control"
                                                            name="file_import" id="customFile"
                                                            accept="application/vnd.ms-excel">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-end">
                                            <button type="button" class="btn btn-default"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal import -->

                        <!-- Modal tambah  -->
                        <div class="modal fade" id="modal-tambah">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah {{ $title }}</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                        </button>
                                    </div>
                                    <form action="{{ route('kkmguru.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="mapel_id" class="col-sm-3 col-form-label">Mata Pelajaran</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" name="mapel_id"
                                                        style="width: 100%;" required>
                                                        <option value="">-- Pilih Mata Pelajaran -- </option>
                                                        @foreach ($data_mapel as $mapel)
                                                            <option value="{{ $mapel->id }}"> {{ $mapel->nama_mapel }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kelas_id" class="col-sm-3 col-form-label">Kelas</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" name="kelas_id"
                                                        style="width: 100%;" required>
                                                        <!--  -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kkm" class="col-sm-3 col-form-label">KKM</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="kkm"
                                                        name="kkm">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-end">
                                            <button type="button" class="btn btn-default"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal tambah -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Semester</th>
                                            <th>Kelas</th>
                                            <th>KKM</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_kkm as $kkm)
                                            @foreach ($kkm as $kkm)
                                                <?php $no++; ?>
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ $kkm->mapel->nama_mapel }}</td>
                                                    <td>{{ $kkm->kelas->tapel->tahun_pelajaran }}
                                                        @if ($kkm->kelas->tapel->semester_id == 1)
                                                            Ganjil
                                                        @else
                                                            Genap
                                                        @endif
                                                    </td>
                                                    <td>Level {{ $kkm->kelas->tingkatan->nama_tingkatan }} -
                                                        {{ $kkm->kelas->nama_kelas }}</td>
                                                    <td>{{ $kkm->kkm }}</td>
                                                    <td>
                                                        <form action="{{ route('kkmguru.destroy', $kkm->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-warning btn-sm mt-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal-edit{{ $kkm->id }}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                            <button type="submit" class="btn btn-danger btn-sm mt-1"
                                                                onclick="return confirm('Hapus {{ $title }} ?')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <!-- Modal edit  -->
                                                <div class="modal fade" id="modal-edit{{ $kkm->id }}">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit {{ $title }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-hidden="true"></button>
                                                            </div>
                                                            <form action="{{ route('kkmguru.update', $kkm->id) }}"
                                                                method="POST">
                                                                {{ method_field('PATCH') }}
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="form-group row">
                                                                        <label for="mapel_id"
                                                                            class="col-sm-3 col-form-label">Mata
                                                                            Pelajaran</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control"
                                                                                id="mapel_id"
                                                                                value="{{ $kkm->mapel->nama_mapel }}"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="kelas_id"
                                                                            class="col-sm-3 col-form-label">Kelas</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control"
                                                                                id="kelas_id"
                                                                                value="{{ $kkm->kelas->nama_kelas }}"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="kkm"
                                                                            class="col-sm-3 col-form-label">KKM</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="number" class="form-control"
                                                                                id="kkm" name="kkm"
                                                                                value="{{ $kkm->kkm }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-end">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </form>
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
        <!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @push('custom-scripts')
        <!-- ajax -->
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
                                    '<option value="">-- Pilih Kelas --</option>'
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
    @endpush
    <!-- end ajax -->
    @include('layouts.main.footer')

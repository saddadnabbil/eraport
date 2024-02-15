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
            'titleBreadCrumb' => $title,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('dashboard'),
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => route('statuskaryawan.index'),
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

            {{-- data table --}}
            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Tambah" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-tambah">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

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
                                    <form action="{{ route('jadwalmengajar.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="tapel_id" value="{{ $tapel->id }}">
                                        <input type="hidden" name="kelas_id" value="{{ $pembelajaran->kelas->id }}">
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="nama" class="col-sm-3 col-form-label">Timetable
                                                    Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nama" name="nama"
                                                        placeholder="Timetable Name" value="{{ old('nama') }}">
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
                                            <th>Timetable Name</th>
                                            <th>Class</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($dataJadwalMengajar as $jadwalMengajar)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $jadwalMengajar->nama }}</td>
                                                <td>{{ $pembelajaran->kelas->nama_kelas }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <div data-bs-toggle="tooltip" data-bs-original-title="Build">
                                                            <a href="{{ route('jadwalmengajar.build', $jadwalMengajar->id) }}"
                                                                class="btn btn-warning btn-sm mt-1">
                                                                <i class="fas fa-hammer"></i>
                                                            </a>
                                                        </div>
                                                        @include('components.actions.delete-button', [
                                                            'route' => route(
                                                                'jadwalmengajar.destroy',
                                                                $jadwalMengajar->id),
                                                            'id' => $jadwalMengajar->id,
                                                            'isPermanent' => true,
                                                            'withEdit' => false,
                                                            'withShow' => true,
                                                            'showRoute' => route(
                                                                'jadwalmengajar.show',
                                                                $jadwalMengajar->id),
                                                        ])
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $jadwalMengajar->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('jadwalmengajar.update', $jadwalMengajar->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="tapel_id"
                                                                value="{{ $tapel->id }}">
                                                            <input type="hidden" name="kelas_id"
                                                                value="{{ $pembelajaran->kelas->id }}">
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="nama"
                                                                        class="col-sm-3 col-form-label">Timetable
                                                                        Name</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="nama" name="nama"
                                                                            placeholder="Timetable Name"
                                                                            value="{{ $jadwalMengajar->nama }}">
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
    </div>
@endsection



@section('footer')
    @include('layouts.main.footer')
@endsection

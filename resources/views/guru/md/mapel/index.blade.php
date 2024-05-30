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
            $dashboard = route('guru.dashboard');
        @endphp
        @include('layouts.partials.breadcrumbs._breadcrumbs-item', [
            'titleBreadCrumb' => $title,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('guru.dashboard'),
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
                            <h3 class="card-title"><i class="fas fa-book"></i> {{ $title }}</h3>
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Create" class="d-inline-block" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-tambah">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div data-bs-toggle="tooltip" title="Import" class="d-inline-block" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-import">
                                        <i class="fas fa-upload"></i>
                                </div>
                                </button>
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
                                    <form name="contact-form" action="{{ route('guru.mapel.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="callout callout-info">
                                                <h5>Download format import</h5>
                                                <p>Silahkan download file format import melalui tombol dibawah ini.</p>
                                                <a href="{{ route('guru.mapel.format_import') }}"
                                                    class="btn btn-primary text-white" style="text-decoration:none"><i
                                                        class="fas fa-file-download"></i> Download</a>
                                            </div>
                                            <div class="form-group row pt-2">
                                                <label for="file_import" class="col-sm-2 col-form-label">File Import</label>
                                                <div class="col-sm-10">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control"
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
                                    <form action="{{ route('guru.mapel.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="tapel_id" value="{{ $tapel->id }}">
                                            <div class="form-group row">
                                                <label for="nama_mapel" class="col-sm-3 col-form-label">Nama Mata
                                                    Pelajaran</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nama_mapel"
                                                        name="nama_mapel" placeholder="Nama Subject"
                                                        value="{{ old('nama_mapel') }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="nama_mapel" class="col-sm-3 col-form-label">Nama Subject
                                                    dalam Bahasa Indonesia</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nama_mapel_indonesian"
                                                        name="nama_mapel_indonesian" placeholder="Nama Subject"
                                                        value="{{ old('nama_mapel') }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="ringkasan_mapel"
                                                    class="col-sm-3 col-form-label">Ringkasan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="ringkasan_mapel"
                                                        name="ringkasan_mapel" placeholder="Ringkasan Mapel"
                                                        value="{{ old('ringkasan_mapel') }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="color" class="col-sm-3 col-form-label">Color</label>
                                                <div class="col-sm-9">
                                                    <input type="color" name="color" id="color-edit"
                                                        value="{{ old('color') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-end">
                                            <button type="button" class="btn btn-default"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
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
                                            <th>Subject</th>
                                            <th>Nama Subject dalam Bahasa Indonesia</th>
                                            <th>Ringkas (Singkatan)</th>
                                            <th>Color</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_mapel as $mapel)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $mapel->nama_mapel }}</td>
                                                <td>{{ $mapel->nama_mapel_indonesian }}</td>
                                                <td>{{ $mapel->ringkasan_mapel }}</td>
                                                <td><input type="color" name="color" value="{{ $mapel->color }}"
                                                        disabled></td>
                                                <td>
                                                    @include('components.actions.delete-button', [
                                                        'route' => route('guru.mapel.destroy', $mapel->id),
                                                        'id' => $mapel->id,
                                                        'isPermanent' => true,
                                                        'withEdit' => true,
                                                        'withShow' => false,
                                                    ])
                                                </td>
                                            </tr>

                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $mapel->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <form action="{{ route('guru.mapel.update', $mapel->id) }}"
                                                            method="POST">
                                                            {{ method_field('PATCH') }}
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="nama_mapel"
                                                                        class="col-sm-3 col-form-label">Nama Mata
                                                                        Pelajaran</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="nama_mapel" name="nama_mapel"
                                                                            value="{{ $mapel->nama_mapel }}">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="nama_mapel"
                                                                        class="col-sm-3 col-form-label">Nama Subject
                                                                        dalam Bahasa Indonesia</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="nama_mapel_indonesian"
                                                                            name="nama_mapel_indonesian"
                                                                            placeholder="Nama Subject"
                                                                            value="{{ $mapel->nama_mapel_indonesian }}">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="ringkasan_mapel"
                                                                        class="col-sm-3 col-form-label">Ringkasan</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="ringkasan_mapel" name="ringkasan_mapel"
                                                                            value="{{ $mapel->ringkasan_mapel }}">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="color"
                                                                        class="col-sm-3 col-form-label">Color</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="color" name="color"
                                                                            id="color-edit" value="{{ $mapel->color }}">
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

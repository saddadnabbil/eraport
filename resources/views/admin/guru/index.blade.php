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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
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
                                <div data-bs-toggle="tooltip" title="Export" class="d-inline-block" class="d-inline-block">
                                    <a href="{{ route('guru.export') }}" class="btn btn-tool btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                <div data-bs-toggle="tooltip" title="Trash" class="d-inline-block" class="d-inline-block">
                                    <a href="{{ route('guru.trash') }}" class="btn btn-tool btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
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
                                    <form name="contact-form" action="{{ route('guru.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="callout callout-info">
                                                <h5>Download format import</h5>
                                                <p>Silahkan download file format import melalui tombol dibawah ini.</p>
                                                <a href="{{ route('guru.format_import') }}"
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
                                    <form action="{{ route('guru.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama
                                                    Lengkap</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nama_lengkap"
                                                        name="nama_lengkap" placeholder="Nama Lengkap"
                                                        value="{{ old('nama_lengkap') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="gelar" class="col-sm-3 col-form-label">Gelar</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="gelar" name="gelar"
                                                        placeholder="Gelar" value="{{ old('gelar') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nip" class="col-sm-3 col-form-label">NIP
                                                    <small><i>(opsional)</i></small></label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="nip"
                                                        name="nip" placeholder="NIP" value="{{ old('nip') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis
                                                    Kelamin</label>
                                                <div class="col-sm-9 pt-1">
                                                    <label class="form-check-label me-3"><input type="radio"
                                                            name="jenis_kelamin" value="Male"
                                                            @if (old('jenis_kelamin') == 'Male') checked @endif required>
                                                        Male</label>
                                                    <label class="form-check-label me-3"><input type="radio"
                                                            name="jenis_kelamin" value="Female"
                                                            @if (old('jenis_kelamin') == 'Female') checked @endif required>
                                                        Female</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat
                                                    Lahir</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="tempat_lahir"
                                                        name="tempat_lahir" placeholder="Tempat Lahir"
                                                        value="{{ old('tempat_lahir') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tanggal_lahir" class="col-sm-3 col-form-label">Tanggal
                                                    Lahir</label>
                                                <div class="col-sm-9">
                                                    <input type="date" class="form-control" id="tanggal_lahir"
                                                        name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nuptk" class="col-sm-3 col-form-label">NUPTK
                                                    <small><i>(opsional)</i></small></label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="nuptk"
                                                        name="nuptk" placeholder="NUPTK" value="{{ old('nuptk') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nuptk" class="col-sm-3 col-form-label">Alamat</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat">{{ old('alamat') }}</textarea>
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
                                            <th>Nama Lengkap</th>
                                            <th>NUPTK</th>
                                            <th>Tempat Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_guru as $guru)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $guru->karyawan->nama_lengkap }} </td>
                                                <td>{{ $guru->nip }}</td>
                                                <td>{{ $guru->nuptk }}</td>
                                                <td>{{ $guru->tempat_lahir }}</td>
                                                <td>
                                                    @if ($guru->jenis_kelamin == 'L')
                                                        Male
                                                    @else
                                                        Female
                                                    @endif
                                                </td>
                                                <td>
                                                    @include('components.actions.delete-button', [
                                                        'route' => route('guru.destroy', $guru->id),
                                                        'id' => $guru->id,
                                                        'isPermanent' => false,
                                                        'withEdit' => true,
                                                        'withShow' => false,
                                                    ])
                                                </td>
                                            </tr>

                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $guru->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <form action="{{ route('guru.update', $guru->id) }}"
                                                            method="POST">
                                                            {{ method_field('PATCH') }}
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="nama_lengkap"
                                                                        class="col-sm-3 col-form-label">Nama
                                                                        Lengkap</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="nama_lengkap" name="nama_lengkap"
                                                                            value="{{ $guru->karyawan->nama_lengkap }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="gelar"
                                                                        class="col-sm-3 col-form-label">Gelar</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="gelar" name="gelar"
                                                                            value="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="nip"
                                                                        class="col-sm-3 col-form-label">NIP
                                                                        <small><i>(opsional)</i></small></label>
                                                                    <div class="col-sm-9">
                                                                        <input type="number" class="form-control"
                                                                            id="nip" name="nip"
                                                                            value="{{ $guru->nip }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="jenis_kelamin"
                                                                        class="col-sm-3 col-form-label">Jenis
                                                                        Kelamin</label>
                                                                    <div class="col-sm-9 pt-1">
                                                                        <label class="form-check-label me-3"><input
                                                                                type="radio" name="jenis_kelamin"
                                                                                value="Male"
                                                                                @if ($guru->jenis_kelamin == 'Male') checked @endif
                                                                                required> Male</label>
                                                                        <label class="form-check-label me-3"><input
                                                                                type="radio" name="jenis_kelamin"
                                                                                value="Female"
                                                                                @if ($guru->jenis_kelamin == 'Female') checked @endif
                                                                                required> Female</label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="tempat_lahir"
                                                                        class="col-sm-3 col-form-label">Tempat
                                                                        Lahir</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="tempat_lahir" name="tempat_lahir"
                                                                            value="{{ $guru->tempat_lahir }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="tanggal_lahir"
                                                                        class="col-sm-3 col-form-label">Tanggal
                                                                        Lahir</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="date" class="form-control"
                                                                            id="tanggal_lahir" name="tanggal_lahir"
                                                                            value="{{ $guru->tanggal_lahir }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="nuptk"
                                                                        class="col-sm-3 col-form-label">NUPTK
                                                                        <small><i>(opsional)</i></small></label>
                                                                    <div class="col-sm-9">
                                                                        <input type="number" class="form-control"
                                                                            id="nuptk" name="nuptk"
                                                                            value="{{ $guru->nuptk }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="nuptk"
                                                                        class="col-sm-3 col-form-label">Alamat</label>
                                                                    <div class="col-sm-9">
                                                                        <textarea class="form-control" id="alamat" name="alamat">{{ $guru->alamat }}</textarea>
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
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
@endsection



@section('footer')
    @include('layouts.main.footer')
@endsection

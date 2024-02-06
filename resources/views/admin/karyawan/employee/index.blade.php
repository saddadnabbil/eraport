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
                    'url' => route('karyawan.index'),
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
                                <div data-bs-toggle="tooltip" title="Import" class="d-inline-block" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-import">
                                        <i class="fas fa-upload"></i>
                                    </button>
                                </div>
                                <div data-bs-toggle="tooltip" title="Export" class="d-inline-block">
                                    <a href="{{ route('karyawan.export') }}" class="btn btn-tool btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                <div data-bs-toggle="tooltip" title="Trash" class="d-inline-block" class="d-inline-block">
                                    <a href="{{ route('karyawan.trash') }}" class="btn btn-tool btn-sm">
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
                                    <form name="contact-form" action="{{ route('karyawan.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="callout callout-info">
                                                <h5>Download format import</h5>
                                                <p>Silahkan download file format import melalui tombol dibawah ini.</p>
                                                <a href="{{ route('karyawan.format_import') }}"
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
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah {{ $title }}</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                        </button>
                                    </div>
                                    <form action="{{ route('karyawan.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <h6 class="mt-2"><b>A. Employee Information</b></h6>
                                            <div class="form-group row">
                                                <label for="status_karyawan_id" class="col-sm-3 col-form-label ">Status
                                                </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control form-select" id="status_karyawan_id"
                                                        name="status_karyawan_id" required>
                                                        <option value="">-- Select Status --
                                                        </option>
                                                        @foreach ($dataStatusKaryawan as $status)
                                                            <option value="{{ $status->id }}"
                                                                {{ old('position_karyawan_id') == $status->id ? 'selected' : '' }}>
                                                                {{ $status->status_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label for="permanent_date" class="col-sm-3 col-form-label "> Permanent
                                                    Date</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" id="permanent_date"
                                                        name="permanent_date" value="{{ old('permanent_date') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="unit_karyawan_id" class="col-sm-3 col-form-label ">Unit
                                                </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control form-select" id="unit_karyawan_id"
                                                        name="unit_karyawan_id" required>
                                                        <option value="">-- Select Unit --
                                                        </option>
                                                        @foreach ($dataUnitKaryawan as $unit)
                                                            <option value="{{ $unit->id }}"
                                                                {{ old('position_karyawan_id') == $unit->id ? 'selected' : '' }}>
                                                                {{ $unit->unit_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label for="position_karyawan_id"
                                                    class="col-sm-3 col-form-label ">Position
                                                </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control form-select" id="position_karyawan_id"
                                                        name="position_karyawan_id" required>
                                                        <option value="">
                                                            -- Select Position --
                                                        </option>
                                                        @foreach ($dataPositionKaryawan as $position)
                                                            <option value="{{ $position->id }}"
                                                                {{ old('position_karyawan_id') == $position->id ? 'selected' : '' }}>
                                                                {{ $position->position_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="join_date" class="col-sm-3 col-form-label ">
                                                    Join Date</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" id="join_date"
                                                        name="join_date" value="{{ old('join_date') }}" required>
                                                </div>
                                            </div>
                                            <h6 class="mt-2"><b>B. Personal Information</b></h6>
                                            <div class="form-group row">
                                                <label for="kode_karyawan" class="col-sm-3 col-form-label ">
                                                    Employee Code</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="kode_karyawan"
                                                        name="kode_karyawan" placeholder="Employee Code"
                                                        value="{{ old('kode_karyawan') }}" required>
                                                </div>
                                                <label for="nama_lengkap" class="col-sm-3 col-form-label ">
                                                    Employee Name</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nama_lengkap"
                                                        name="nama_lengkap" placeholder="Employee Name"
                                                        value="{{ old('nama_lengkap') }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nik" class="col-sm-3 col-form-label ">
                                                    Identity Card</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nik"
                                                        name="nik" placeholder="Identity Card"
                                                        value="{{ old('nik') }}" required>
                                                </div>
                                                <label for="nomor_akun" class="col-sm-3 col-form-label ">
                                                    Account No.</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nomor_akun"
                                                        name="nomor_akun" placeholder="Account No."
                                                        value="{{ old('nomor_akun') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nomor_fingerprint" class="col-sm-3 col-form-label ">
                                                    Fingerprint No.</label>
                                                <div class="col-sm-3">
                                                    <input type="number" class="form-control" id="nomor_fingerprint"
                                                        name="nomor_fingerprint" placeholder="Fingerprint No."
                                                        value="{{ old('nomor_fingerprint') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nomor_taxpayer" class="col-sm-3 col-form-label ">
                                                    Taxpayer No.</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nomor_taxpayer"
                                                        name="nomor_taxpayer" placeholder="Taxpayer No."
                                                        value="{{ old('nomor_taxpayer') }}">
                                                </div>
                                                <label for="nama_taxpayer" class="col-sm-3 col-form-label ">
                                                    Name of Taxpayer</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nama_taxpayer"
                                                        name="nama_taxpayer" placeholder="Name of Taxpayer"
                                                        value="{{ old('nama_taxpayer') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nomor_bpjs_ketenagakerjaan" class="col-sm-3 col-form-label ">
                                                    No BPJS Ketenagakerjaan</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control"
                                                        id="nomor_bpjs_ketenagakerjaan" name="nomor_bpjs_ketenagakerjaan"
                                                        placeholder="No BPJS Ketenagakerjaan"
                                                        value="{{ old('nomor_bpjs_ketenagakerjaan') }}">
                                                </div>
                                                <label for="iuran_bpjs_ketenagakerjaan" class="col-sm-3 col-form-label ">
                                                    Iuran BPJS Ketenagakerjaan</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control"
                                                        id="iuran_bpjs_ketenagakerjaan" name="iuran_bpjs_ketenagakerjaan"
                                                        placeholder="Iuran BPJS Ketenagakerjaan"
                                                        value="{{ old('iuran_bpjs_ketenagakerjaan') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nomor_bpjs_yayasan" class="col-sm-3 col-form-label ">
                                                    No BPJS Kesehatan (Yayasan)</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nomor_bpjs_yayasan"
                                                        name="nomor_bpjs_yayasan"
                                                        placeholder="No BPJS Kesehatan (Yayasan)"
                                                        value="{{ old('nomor_bpjs_yayasan') }}">
                                                </div>
                                                <label for="nomor_bpjs_pribadi" class="col-sm-3 col-form-label ">
                                                    No BPJS Kesehatan (Pribadi)</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nomor_bpjs_pribadi"
                                                        name="nomor_bpjs_pribadi"
                                                        placeholder="No BPJS Kesehatan (Pribadi)"
                                                        value="{{ old('nomor_bpjs_pribadi') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jenis_kelamin"
                                                    class="col-sm-3 col-form-label required">Gender</label>
                                                <div class="col-sm-3 pt-1">
                                                    <label class="form-check-label me-3"><input type="radio"
                                                            name="jenis_kelamin" value="MALE"
                                                            @if (old('jenis_kelamin') == 'MALE') checked @endif required>
                                                        Male</label>
                                                    <label class="form-check-label me-3"><input type="radio"
                                                            name="jenis_kelamin" value="FEMALE"
                                                            @if (old('jenis_kelamin') == 'FEMALE') checked @endif required>
                                                        Female</label>
                                                </div>
                                                <label for="agama"
                                                    class="col-sm-3 col-form-label required">Religion</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control form-select" name="agama" required>
                                                        <option value="">-- Select Religion --</option>
                                                        <option value="1">Islam</option>
                                                        <option value="2">Protestan</option>
                                                        <option value="3">Katolik</option>
                                                        <option value="4">Hindu</option>
                                                        <option value="5">Budha</option>
                                                        <option value="6">Khonghucu</option>
                                                        <option value="7">Kepercayaan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tempat_lahir" class="col-sm-3 col-form-label required">Tempat
                                                    Lahir</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="tempat_lahir"
                                                        name="tempat_lahir" placeholder="Tempat Lahir"
                                                        value="{{ old('tempat_lahir') }}">
                                                </div>
                                                <label for="tanggal_lahir"
                                                    class="col-sm-3 col-form-label required">Tanggal
                                                    Lahir</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" id="tanggal_lahir"
                                                        name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="alamat"
                                                    class="col-sm-3 col-form-label required">Address</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Address" required>{{ old('alamat') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="alamat_sekarang" class="col-sm-3 col-form-label required">
                                                    Current
                                                    Address</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="alamat_sekarang" name="alamat_sekarang" placeholder="Current Address ">{{ old('alamat_sekarang') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kota" class="col-sm-3 col-form-label">City</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="kota"
                                                        name="kota" placeholder="City" value="{{ old('kota') }}">
                                                </div>
                                                <label for="kode_pos" class="col-sm-3 col-form-label ">Pos Code</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="kode_pos"
                                                        name="kode_pos" value="{{ old('kode_pos') }}"
                                                        placeholder="Pos Code" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nomor_hp" class="col-sm-3 col-form-label ">Handphone</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nomor_hp"
                                                        name="nomor_hp" value="{{ old('nomor_hp') }}"
                                                        placeholder="Handphone" required>
                                                </div>
                                                <label for="nomor_phone" class="col-sm-3 col-form-label">Phone</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nomor_phone"
                                                        name="nomor_phone" placeholder="Phone"
                                                        value="{{ old('nomor_phone') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="email"
                                                        name="email" placeholder="Email" value="{{ old('email') }}" required>
                                                </div>
                                                <label for="email_sekolah" class="col-sm-3 col-form-label ">Email
                                                    School</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="email_sekolah"
                                                        name="email_sekolah" value="{{ old('email_sekolah') }}"
                                                        placeholder="Email School">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="warga_negara" class="col-sm-3 col-form-label">Marital
                                                    Status</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control form-select" name="status_pernikahan"
                                                        id="status_pernikahan">
                                                        <option value="">-- Select Marital Status --</option>
                                                        <option value="1"
                                                            @if (old('status_pernikahan') == 1) selected @endif>Single
                                                        </option>
                                                        <option value="2"
                                                            @if (old('status_pernikahan') == 2) selected @endif>Merried
                                                        </option>
                                                        <option value="3"
                                                            @if (old('status_pernikahan') == 3) selected @endif>Widow
                                                        </option>
                                                        <option value="3"
                                                            @if (old('status_pernikahan') == 3) selected @endif>Widower
                                                        </option>
                                                    </select>
                                                </div>
                                                <label for="nama_pasangan" class="col-sm-3 col-form-label">Spouse</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nama_pasangan"
                                                        name="nama_pasangan" placeholder="Spouse"
                                                        value="{{ old('nama_pasangan') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jumlah_anak" class="col-sm-3 col-form-label">Number of
                                                    Chilldren</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="jumlah_anak"
                                                        name="jumlah_anak" placeholder="Number of Chilldren"
                                                        value="{{ old('jumlah_anak') }}">
                                                </div>
                                                <label for="warga_negara" class="col-sm-3 col-form-label">Citizen</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="warga_negara"
                                                        name="warga_negara" placeholder="Citizen"
                                                        value="{{ old('warga_negara') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="keterangan" class="col-sm-3 col-form-label">Note</label>
                                                <div class="col-sm-9">
                                                    <textarea name="keterangan" class="form-control" id="keterangan" placeholder="Note"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="pas_photo" class="col-sm-3 col-form-label required">
                                                    Photo</label>
                                                <div class="col-sm-6 custom-file">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="pas_photo"
                                                                class="custom-file-input form-control form-control"
                                                                id="pas_photo" onchange="readURLPasPhoto(this);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <img src="{{ asset('assets/dist/img/3x4.png') }}" alt=""
                                                        id="pas_photo_preview" width="105px" height="144px">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="photo_kartu_identitas" class="col-sm-3 col-form-label ">Photo
                                                    Identity Card</label>
                                                <div class="col-sm-6 custom-file">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="photo_kartu_identitas"
                                                                class="custom-file-input form-control form-control"
                                                                id="photo_kartu_identitas"
                                                                onchange="readURLKartuIdentitas(this);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                                        id="photo_kartu_identitas_preview" width="190px" height="144px">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="photo_taxpayer" class="col-sm-3 col-form-label ">Photo
                                                    Taxpayer</label>
                                                <div class="col-sm-6 custom-file">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="photo_taxpayer"
                                                                class="custom-file-input form-control form-control"
                                                                id="photo_taxpayer" onchange="readURLTaxpayer(this);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                                        id="photo_taxpayer_preview" width="190px" height="144px">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="photo_kk" class="col-sm-3 col-form-label ">Photo
                                                    Family Card</label>
                                                <div class="col-sm-6 custom-file">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="photo_kk"
                                                                class="custom-file-input form-control form-control"
                                                                id="photo_kk" onchange="readURLKK(this);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                                        id="photo_kk_preview" width="190px" height="144px">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="other_document" class="col-sm-3 col-form-label ">
                                                    Other Document</label>
                                                <div class="col-sm-6 custom-file">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="other_document"
                                                                class="custom-file-input form-control form-control"
                                                                id="other_document"
                                                                onchange="readURLOtherDocument(this);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                                        id="other_document_preview" width="190px" height="144px">
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
                                            <th>Employee Code</th>
                                            <th>Employee Name</th>
                                            <th>Sex</th>
                                            <th>Status Employee</th>
                                            <th>Unit</th>
                                            <th>Position</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($dataKaryawan as $karyawan)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $karyawan->kode_karyawan }}</td>
                                                <td>{{ $karyawan->nama_lengkap }}</td>
                                                <td>{{ $karyawan->jenis_kelamin }}</td>
                                                <td>{{ $karyawan->statusKaryawan->status_nama }}</td>
                                                <td>{{ $karyawan->unitKaryawan->unit_nama }}</td>
                                                <td>{{ $karyawan->positionKaryawan->position_nama }}</td>
                                                <td>
                                                    @if ($karyawan->status == true)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Non Aktif</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @include('components.actions.delete-button', [
                                                        'route' => route('karyawan.destroy', $karyawan->id),
                                                        'id' => $karyawan->id,
                                                        'isPermanent' => true,
                                                        'withEdit' => false,
                                                        'withShow' => true,
                                                        'showRoute' => route('karyawan.show', $karyawan->id),
                                                    ])
                                                </td>
                                            </tr>

                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $karyawan->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit
                                                                {{ $title }}</h5>

                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <form action="{{ route('karyawan.update', $karyawan->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Position
                                                                        Code</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="position_kode" name="position_kode"
                                                                            placeholder="Position Code"
                                                                            value="{{ $karyawan->position_kode }}"
                                                                            disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Position
                                                                        Name</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="position_nama" name="position_nama"
                                                                            placeholder="Position Name"
                                                                            value="{{ $karyawan->position_nama }}">
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

@push('custom-scripts')
    <!-- pas_photo preview-->
    <script>
        function readURLPasPhoto(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#pas_photo_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLKartuIdentitas(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#photo_kartu_identitas_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLTaxpayer(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#photo_taxpayer_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLKK(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#photo_kk_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLOtherDocument(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#other_document_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush

@section('footer')
    @include('layouts.main.footer')
@endsection

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
                    'url' => route('tapel.index'),
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
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-layer-group  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Playgroup</span>
                            <span class="info-box-number">{{ $jumlah_kelas_play_group }} <small>students</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-book  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Kindergarten</span>
                            <span class="info-box-number">{{ $jumlah_kelas_kinder_garten }} <small>students</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                {{-- <div class="clearfix hidden-md-up"></div> --}}

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Primary School</span>
                            <span class="info-box-number">{{ $jumlah_kelas_primary_school }} <small>students</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fas fa-book-reader text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Junior High School</span>
                            <span class="info-box-number">{{ $jumlah_kelas_junior_high_school }}
                                <small>students</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fas fa-book-reader  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Senior High School</span>
                            <span class="info-box-number">{{ $jumlah_kelas_senior_high_school }}
                                <small>students</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> {{ $title }}</h3>
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
                                    <a href="{{ route('siswa.export') }}" class="btn btn-tool btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                <div data-bs-toggle="tooltip" title="Trash" class="d-inline-block" class="d-inline-block">
                                    <a href="{{ route('siswa.trash') }}" class="btn btn-tool btn-sm">
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
                                    <form name="contact-form" action="{{ route('siswa.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="callout callout-info">
                                                <h5>Download format import</h5>
                                                <p>Silahkan download file format import melalui tombol dibawah ini.</p>
                                                <a href="{{ route('siswa.format_import') }}"
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
                                                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

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
                                    <form action="{{ route('siswa.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="container">
                                                <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                                    <li class="nav-item">
                                                        <a href="#student1" data-bs-toggle="tab" aria-expanded="false"
                                                            class="nav-link rounded-0 active">
                                                            <i class="mdi mdi-home-variant d-lg-none d-block me-1"></i>
                                                            <span class="d-none d-lg-block">Student</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#father1" data-bs-toggle="tab" aria-expanded="true"
                                                            class="nav-link rounded-0 ">
                                                            <i class="mdi mdi-account-circle d-lg-none d-block me-1"></i>
                                                            <span class="d-none d-lg-block">Father</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#mother1" data-bs-toggle="tab" aria-expanded="true"
                                                            class="nav-link rounded-0">
                                                            <i class="mdi mdi-account-circle d-lg-none d-block me-1"></i>
                                                            <span class="d-none d-lg-block">Mother</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#guardian1" data-bs-toggle="tab" aria-expanded="false"
                                                            class="nav-link rounded-0">
                                                            <i class="mdi mdi-settings-outline d-lg-none d-block me-1"></i>
                                                            <span class="d-none d-lg-block">Guardian</span>
                                                        </a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div class="tab-pane show active" id="student1">
                                                        {{-- A. Personal Information --}}
                                                        <div class="border-bottom p-2">
                                                            <h6 class="mt-2"><b>A. Personal Information</b></h6>
                                                            <div class="form-group row">
                                                                <label for="nis"
                                                                    class="col-sm-3 col-form-label required">NIS</label>
                                                                <div class="col-sm-3">
                                                                    <input type="number" class="form-control"
                                                                        id="nis" name="nis" placeholder="NIS"
                                                                        value="{{ old('nis') }}" required>
                                                                </div>
                                                                <label for="nisn"
                                                                    class="col-sm-2 col-form-label">NISN</label>
                                                                <div class="col-sm-4">
                                                                    <input type="number" class="form-control"
                                                                        id="nisn" name="nisn" placeholder="NISN"
                                                                        value="{{ old('nisn') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="nik"
                                                                    class="col-sm-3 col-form-label required">NIK</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nik" name="nik" placeholder="NIK"
                                                                        value="{{ old('nik') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="nama_lengkap"
                                                                    class="col-sm-3 col-form-label required">Nama
                                                                    Siswa</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nama_lengkap" name="nama_lengkap"
                                                                        placeholder="Nama Siswa"
                                                                        value="{{ old('nama_lengkap') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="nama_panggilan"
                                                                    class="col-sm-3 col-form-label required">Nama
                                                                    Panggilan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nama_panggilan" name="nama_panggilan"
                                                                        placeholder="Nama Panggilan"
                                                                        value="{{ old('nama_panggilan') }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label
                                                                    class=" col-sm-3 col-form-label required">Tingkatan</label>
                                                                <div class="col-sm-3">
                                                                    <select class="form-control form-select"
                                                                        id="kelas" name="tingkatan_id" required>
                                                                        <option value="">-- Pilih Tingkatan --
                                                                        </option>
                                                                        @foreach ($data_tingkatan as $tingkatan)
                                                                            <option value="{{ $tingkatan->id }}">
                                                                                {{ $tingkatan->nama_tingkatan }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <label
                                                                    class="col-sm-2 col-form-label required">Kelas</label>
                                                                <div class="col-sm-4">
                                                                    <select class="form-control form-select"
                                                                        id="kelas_id" name="kelas_id" required>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="nama_wali"
                                                                    class="col-sm-3 col-form-label required">Jenis
                                                                    Pendaftaran</label>
                                                                <div class="col-sm-3 pt-1">
                                                                    <label class="form-check-label me-3"><input
                                                                            type="radio" name="jenis_pendaftaran"
                                                                            onchange='CheckPendaftaran(this.value);'
                                                                            value="1"
                                                                            @if (old('jenis_pendaftaran') == '1') checked @endif
                                                                            required> Siswa Baru</label>
                                                                    <label class="form-check-label me-3"><input
                                                                            type="radio" name="jenis_pendaftaran"
                                                                            onchange='CheckPendaftaran(this.value);'
                                                                            value="2"
                                                                            @if (old('jenis_pendaftaran') == '2') checked @endif
                                                                            required> Pindahan</label>
                                                                </div>
                                                                <label
                                                                    class="col-sm-2 col-form-label required">Jurusan</label>
                                                                <div class="col-sm-4">
                                                                    <select class="form-control form-select"
                                                                        id="jurusan_id" name="jurusan_id" required>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="tahun_masuk"
                                                                    class="col-sm-3 col-form-label required">Tahun
                                                                    Masuk</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" name="tahun_masuk"
                                                                        id="tahun_masuk" class="form-control"
                                                                        placeholder="Tahun Masuk"
                                                                        value="{{ old('tahun_masuk') }}">
                                                                </div>
                                                                <label for="semester_masuk"
                                                                    class="col-sm-2 col-form-label required">Semester
                                                                    Masuk</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" name="semester_masuk"
                                                                        id="semester_masuk" class="form-control"
                                                                        placeholder="Semester Masuk"
                                                                        value="{{ old('semester_masuk') }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="jenis_kelamin"
                                                                    class="col-sm-3 col-form-label required">Jenis
                                                                    Kelamin</label>
                                                                <div class="col-sm-3 pt-1">
                                                                    <label class="form-check-label me-3"><input
                                                                            type="radio" name="jenis_kelamin"
                                                                            value="MALE"
                                                                            @if (old('jenis_kelamin') == 'MALE') checked @endif
                                                                            required> Male</label>
                                                                    <label class="form-check-label me-3"><input
                                                                            type="radio" name="jenis_kelamin"
                                                                            value="FEMALE"
                                                                            @if (old('jenis_kelamin') == 'FEMALE') checked @endif
                                                                            required> Female</label>
                                                                </div>
                                                                <label for="bloodtype"
                                                                    class="col-sm-2 col-form-label">Gol. Darah</label>
                                                                <div class="col-sm-4">
                                                                    <select class="form-control form-select"
                                                                        name="bloodtype">
                                                                        <option value="">-- Pilih Gol. Darah --
                                                                        </option>
                                                                        <option value="A">A</option>
                                                                        <option value="B">B</option>
                                                                        <option value="AB">AB</option>
                                                                        <option value="O">O</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="tempat_lahir"
                                                                    class="col-sm-3 col-form-label required">Tempat
                                                                    Lahir</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="tempat_lahir" name="tempat_lahir"
                                                                        placeholder="Tempat Lahir"
                                                                        value="{{ old('tempat_lahir') }}">
                                                                </div>
                                                                <label for="tanggal_lahir"
                                                                    class="col-sm-2 col-form-label required">Tanggal
                                                                    Lahir</label>
                                                                <div class="col-sm-4">
                                                                    <input type="date" class="form-control"
                                                                        id="tanggal_lahir" name="tanggal_lahir"
                                                                        value="{{ old('tanggal_lahir') }}" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="agama"
                                                                    class="col-sm-3 col-form-label required">Agama</label>
                                                                <div class="col-sm-3">
                                                                    <select class="form-control form-select"
                                                                        name="agama" required>
                                                                        <option value="">-- Pilih Agama --</option>
                                                                        <option value="1">Islam</option>
                                                                        <option value="2">Protestan</option>
                                                                        <option value="3">Katolik</option>
                                                                        <option value="4">Hindu</option>
                                                                        <option value="5">Budha</option>
                                                                        <option value="6">Khonghucu</option>
                                                                        <option value="7">Lainnya</option>
                                                                    </select>
                                                                </div>

                                                                <label for="kewarganegaraan"
                                                                    class="col-sm-2 col-form-label">Kewarganegaraan</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control"
                                                                        id="kewarganegaraan" name="kewarganegaraan"
                                                                        placeholder="Kewarganegaraan"
                                                                        value="{{ old('kewarganegaraan') }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="jml_saudara_kandung"
                                                                    class="col-sm-3 col-form-label">Jumlah Saudara
                                                                    Kandung</label>
                                                                <div class="col-sm-3">
                                                                    <input type="number" class="form-control"
                                                                        id="jml_saudara_kandung"
                                                                        name="jml_saudara_kandung"
                                                                        value="{{ old('dari') }}">
                                                                </div>
                                                                <label for="anak_ke" class="col-sm-2 col-form-label">Anak
                                                                    Ke</label>
                                                                <div class="col-sm-4">
                                                                    <input type="number" class="form-control"
                                                                        id="anak_ke" name="anak_ke"
                                                                        value="{{ old('anak_ke') }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="pas_photo"
                                                                    class="col-sm-3 col-form-label required">Pas
                                                                    Photo</label>
                                                                <div class="col-sm-4 custom-file">
                                                                    <div class="input-group">
                                                                        <div class="custom-file">
                                                                            <input type="file" name="pas_photo"
                                                                                class="custom-file-input form-control form-control"
                                                                                id="pas_photo" onchange="readURL(this);"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <img src="{{ asset('assets/dist/img/3x4.png') }}"
                                                                        alt="" id="pas_photo_preview"
                                                                        width="105px" height="144px">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- B. Domicile Information --}}
                                                        <div class="border-bottom mt-3 p-2">
                                                            <h6 class="mt-2"><b>B. Domicile Information</b></h6>
                                                            <div class="form-group row">
                                                                <label for="alamat"
                                                                    class="col-sm-3 col-form-label required">Alamat</label>
                                                                <div class="col-sm-9">
                                                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="kota"
                                                                    class="col-sm-3 col-form-label required">Kota</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="kota" name="kota" placeholder="Kota"
                                                                        value="{{ old('kota') }}">
                                                                </div>
                                                                <label for="kode_pos"
                                                                    class="col-sm-2 col-form-label required">Kode
                                                                    Pos</label>
                                                                <div class="col-sm-4">
                                                                    <input type="number" class="form-control"
                                                                        id="kode_pos" name="kode_pos"
                                                                        placeholder="Kode Pos"
                                                                        value="{{ old('kode_pos') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="jarak_rumah_ke_sekolah"
                                                                    class="col-sm-3 col-form-label">Jarak Rumah ke Sekolah
                                                                    (km)</label>
                                                                <div class="col-sm-9">
                                                                    <input type="number" name="jarak_rumah_ke_sekolah"
                                                                        id="jarak_rumah_ke_sekolah"
                                                                        placeholder="Jarak Rumah ke Sekola (km)"
                                                                        class="form-control"
                                                                        value="{{ old('jarak_rumah_ke_sekolah') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row required">
                                                                <label for="email"
                                                                    class="col-sm-3 col-form-label">Email</label>
                                                                <div class="col-sm-9">
                                                                    <input type="email" class="form-control"
                                                                        id="email" name="email" placeholder="Email"
                                                                        value="{{ old('email') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="email_parent"
                                                                    class="col-sm-3 col-form-label">Email Parent</label>
                                                                <div class="col-sm-9">
                                                                    <input type="email" class="form-control"
                                                                        id="email_parent" name="email_parent"
                                                                        placeholder="Email Parent"
                                                                        value="{{ old('email_parent') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row required">
                                                                <label for="nomor_hp"
                                                                    class="col-sm-3 col-form-label">Nomor HP</label>
                                                                <div class="col-sm-9">
                                                                    <input type="number" class="form-control"
                                                                        id="nomor_hp" name="nomor_hp"
                                                                        placeholder="Nomor HP"
                                                                        value="{{ old('nomor_hp') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="tinggal_bersama"
                                                                    class="col-sm-3 col-form-label">Tinggal Bersama</label>
                                                                <div class="col-sm-3">
                                                                    <select class="form-control form-select"
                                                                        name="tinggal_bersama">
                                                                        <option value="">-- Pilih Tinggal Bersama --
                                                                        </option>
                                                                        <option value="Parents">Parents</option>
                                                                        <option value="Others">Others</option>
                                                                    </select>
                                                                </div>
                                                                <label for="transportasi"
                                                                    class="col-sm-2 col-form-label">Transportasi</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control"
                                                                        id="transportasi" name="transportasi"
                                                                        placeholder="Transportasi"
                                                                        value="{{ old('transportasi') }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- C. Student Medical Condition --}}
                                                        <div class="border-bottom mt-3 p-2">
                                                            <h6 class="mt-2"><b>C. Student Medical Condition</b></h6>

                                                            <div class="form-group row">
                                                                <label for="tinggi_badan"
                                                                    class="col-sm-3 col-form-label">Tinggi Badan</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="tinggi_badan" name="tinggi_badan"
                                                                        placeholder="Tinggi Badan"
                                                                        value="{{ old('tinggi_badan') }}">
                                                                </div>
                                                                <label for="berat_badan"
                                                                    class="col-sm-2 col-form-label">Berat Badan</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control"
                                                                        id="berat_badan" name="berat_badan"
                                                                        placeholder="Berat Badan"
                                                                        value="{{ old('berat_badan') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="spesial_treatment"
                                                                    class="col-sm-3 col-form-label">Spesial
                                                                    Treatment</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="spesial_treatment" name="spesial_treatment"
                                                                        placeholder="Spesial Treatment"
                                                                        value="{{ old('spesial_treatment') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="note_kesehatan"
                                                                    class="col-sm-3 col-form-label">Note Kesehatan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="note_kesehatan" name="note_kesehatan"
                                                                        placeholder="Note Kesehatan"
                                                                        value="{{ old('note_kesehatan') }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="file_document_kesehatan"
                                                                    class="col-sm-3 col-form-label">File Document
                                                                    Kesehatan</label>
                                                                <div class="col-sm-9 custom-file">
                                                                    <div class="input-group">
                                                                        <div class="custom-file">
                                                                            <input type="file"
                                                                                name="file_document_kesehatan"
                                                                                class="custom-file-input form-control form-control"
                                                                                id="file_document_kesehatan">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="file_list_pertanyaan"
                                                                    class="col-sm-3 col-form-label">File List
                                                                    Pertanyaan</label>
                                                                <div class="col-sm-9 custom-file">
                                                                    <div class="input-group">
                                                                        <div class="custom-file">
                                                                            <input type="file"
                                                                                name="file_list_pertanyaan"
                                                                                class="custom-file-input form-control form-control"
                                                                                id="file_list_pertanyaan">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- D. Previously Formal School --}}
                                                        <div class="mt-3 p-2">
                                                            <h6 class="mt-2"><b>D. Previously Formal School</b></h6>
                                                            <div class="form-group row">
                                                                <label for="tanggal_masuk_sekolah_lama"
                                                                    class="col-sm-3 col-form-label">Tgl. Masuk
                                                                    Sekolah</label>
                                                                <div class="col-sm-3">
                                                                    <input type="date" class="form-control"
                                                                        id="tanggal_masuk_sekolah_lama"
                                                                        name="tanggal_masuk_sekolah_lama"
                                                                        placeholder="Tgl. Masuk Sekolah"
                                                                        value="{{ old('tanggal_masuk_sekolah_lama') }}">
                                                                </div>
                                                                <label for="tanggal_keluar_sekolah_lama"
                                                                    class="col-sm-2 col-form-label">Tgl. Keluar
                                                                    Sekolah</label>
                                                                <div class="col-sm-4">
                                                                    <input type="date" class="form-control"
                                                                        id="tanggal_keluar_sekolah_lama"
                                                                        name="tanggal_keluar_sekolah_lama"
                                                                        placeholder="Tgl. Keluar Sekolah"
                                                                        value="{{ old('tanggal_keluar_sekolah_lama') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="nama_sekolah_lama"
                                                                    class="col-sm-3 col-form-label">Nama Sekolah</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nama_sekolah_lama" name="nama_sekolah_lama"
                                                                        placeholder="Nama Sekolah"
                                                                        value="{{ old('nama_sekolah_lama') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="alamat_lama"
                                                                    class="col-sm-3 col-form-label">Alamat Sekolah</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="alamat_lama" name="alamat_lama"
                                                                        placeholder="Alamat Sekolah"
                                                                        value="{{ old('alamat_lama') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="no_sttb" class="col-sm-3 col-form-label">No.
                                                                    STTB</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="no_sttb" name="no_sttb"
                                                                        placeholder="No. STTB"
                                                                        value="{{ old('no_sttb') }}">
                                                                </div>
                                                                <label for="nem"
                                                                    class="col-sm-2 col-form-label">NEM</label>
                                                                <div class="col-sm-4">
                                                                    <input type="number" class="form-control"
                                                                        id="nem" name="nem" placeholder="NEM"
                                                                        value="{{ old('nem') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="file_dokument_sekolah_lama"
                                                                    class="col-sm-3 col-form-label">File Dokument Sekolah
                                                                    Lama</label>
                                                                <div class="col-sm-9 custom-file">
                                                                    <div class="input-group">
                                                                        <div class="custom-file">
                                                                            <input type="file"
                                                                                name="file_dokument_sekolah_lama"
                                                                                class="custom-file-input form-control form-control"
                                                                                id="file_dokument_sekolah_lama">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="father1">
                                                        {{-- A. Father --}}
                                                        <div class="border-bottom p-2">
                                                            <h6 class="mt-2"><b>A. Father</b></h6>
                                                            <div class="form-group row">
                                                                <label for="nik_ayah"
                                                                    class="col-sm-3 col-form-label required">NIK</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nik_ayah" name="nik_ayah" placeholder="NIK"
                                                                        value="{{ old('nik_ayah') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="nama_ayah"
                                                                    class="col-sm-3 col-form-label required">Nama</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nama_ayah" name="nama_ayah"
                                                                        placeholder="Nama" value="{{ old('nama_ayah') }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="tempat_lahir_ayah"
                                                                    class="col-sm-3 col-form-label">Tempat Lahir</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="tempat_lahir_ayah" name="tempat_lahir_ayah"
                                                                        placeholder="Tempat Lahir"
                                                                        value="{{ old('tempat_lahir_ayah') }}">
                                                                </div>
                                                                <label for="tanggal_lahir_ayah"
                                                                    class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                                                <div class="col-sm-3">
                                                                    <input type="date" class="form-control"
                                                                        id="tanggal_lahir_ayah" name="tanggal_lahir_ayah"
                                                                        placeholder="Tanggal Lahir"
                                                                        value="{{ old('tanggal_lahir_ayah') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="alamat_ayah"
                                                                    class="col-sm-3 col-form-label">Alamat</label>
                                                                <div class="col-sm-9">
                                                                    <textarea class="form-control" id="alamat_ayah" name="alamat_ayah" placeholder="Alamat">{{ old('alamat_ayah') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="nomor_hp_ayah"
                                                                    class="col-sm-3 col-form-label">Nomor HP</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nomor_hp_ayah" name="nomor_hp_ayah"
                                                                        placeholder="Nomor HP"
                                                                        value="{{ old('nomor_hp_ayah') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="agama_ayah"
                                                                    class="col-sm-3 col-form-label">Agama</label>
                                                                <div class="col-sm-9">
                                                                    <select class="form-control form-select"
                                                                        id="agama_ayah" name="agama_ayah">
                                                                        <option selected>-- Pilih Agama --</option>
                                                                        <option value="1">Islam</option>
                                                                        <option value="2">Kristen</option>
                                                                        <option value="3">Katolik</option>
                                                                        <option value="4">Hindu</option>
                                                                        <option value="5">Budha</option>
                                                                        <option value="6">Khonghucu</option>
                                                                        <option value="7">Lainnya</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="kota_ayah"
                                                                    class="col-sm-3 col-form-label">Kota</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="kota_ayah" name="kota_ayah"
                                                                        placeholder="Kota"
                                                                        value="{{ old('kota_ayah') }}">
                                                                </div>
                                                                <label for="pendidikan_terakhir_ayah"
                                                                    class="col-sm-3 col-form-label">Pendidikan
                                                                    Terakhir</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="pendidikan_terakhir_ayah"
                                                                        name="pendidikan_terakhir_ayah"
                                                                        placeholder="Pendidikan Terakhir"
                                                                        value="{{ old('pendidikan_terakhir_ayah') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="pekerjaan_ayah"
                                                                    class="col-sm-3 col-form-label required">Pekerjaan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="pekerjaan_ayah" name="pekerjaan_ayah"
                                                                        placeholder="Pekerjaan"
                                                                        value="{{ old('pekerjaan_ayah') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="penghasilan_ayah"
                                                                    class="col-sm-3 col-form-label">Penghasilan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="penghasilan_ayah" name="penghasilan_ayah"
                                                                        placeholder="Penghasilan"
                                                                        value="{{ old('penggayaran_ayah') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="mother1">
                                                        {{-- A. Mother --}}
                                                        <div class="border-bottom p-2">
                                                            <h6 class="mt-2"><b>A. Mother</b></h6>
                                                            <div class="form-group row">
                                                                <label for="nik_ibu"
                                                                    class="col-sm-3 col-form-label required">NIK</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nik_ibu" name="nik_ibu" placeholder="NIK"
                                                                        value="{{ old('nik_ibu') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="nama_ibu"
                                                                    class="col-sm-3 col-form-label required">Nama</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nama_ibu" name="nama_ibu" placeholder="Nama"
                                                                        value="{{ old('nama_ibu') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="tempat_lahir_ibu"
                                                                    class="col-sm-3 col-form-label">Tempat Lahir</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="tempat_lahir_ibu" name="tempat_lahir_ibu"
                                                                        placeholder="Tempat Lahir"
                                                                        value="{{ old('tempat_lahir_ibu') }}">
                                                                </div>
                                                                <label for="tanggal_lahir_ibu"
                                                                    class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                                                <div class="col-sm-3">
                                                                    <input type="date" class="form-control"
                                                                        id="tanggal_lahir_ibu" name="tanggal_lahir_ibu"
                                                                        placeholder="Tanggal Lahir"
                                                                        value="{{ old('tanggal_lahir_ibu') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="alamat_ibu"
                                                                    class="col-sm-3 col-form-label">Alamat</label>
                                                                <div class="col-sm-9">
                                                                    <textarea class="form-control" id="alamat_ibu" name="alamat_ibu" placeholder="Alamat">{{ old('alamat_ibu') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="nomor_hp_ibu"
                                                                    class="col-sm-3 col-form-label">Nomor HP</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nomor_hp_ibu" name="nomor_hp_ibu"
                                                                        placeholder="Nomor HP"
                                                                        value="{{ old('nomor_hp_ibu') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="agama_ibu"
                                                                    class="col-sm-3 col-form-label">Agama</label>
                                                                <div class="col-sm-9">
                                                                    <select class="form-control form-select"
                                                                        id="agama_ibu" name="agama_ibu">
                                                                        <option selected>-- Pilih Agama --</option>
                                                                        <option value="1">Islam</option>
                                                                        <option value="2">Kristen</option>
                                                                        <option value="3">Katolik</option>
                                                                        <option value="4">Hindu</option>
                                                                        <option value="5">Budha</option>
                                                                        <option value="6">Khonghucu</option>
                                                                        <option value="7">Lainnya</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="kota_ibu"
                                                                    class="col-sm-3 col-form-label">Kota</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="kota_ibu" name="kota_ibu" placeholder="Kota"
                                                                        value="{{ old('kota_ibu') }}">
                                                                </div>
                                                                <label for="pendidikan_terakhir_ibu"
                                                                    class="col-sm-3 col-form-label">Pendidikan
                                                                    Terakhir</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="pendidikan_terakhir_ibu"
                                                                        name="pendidikan_terakhir_ibu"
                                                                        placeholder="Pendidikan Terakhir"
                                                                        value="{{ old('pendidikan_terakhir_ibu') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="pekerjaan_ibu"
                                                                    class="col-sm-3 col-form-label required">Pekerjaan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="pekerjaan_ibu" name="pekerjaan_ibu"
                                                                        placeholder="Pekerjaan Ayah"
                                                                        value="{{ old('pekerjaan_ibu') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="penghasilan_ibu"
                                                                    class="col-sm-3 col-form-label">Penghasilan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="penghasilan_ibu" name="penghasilan_ibu"
                                                                        placeholder="Penghasilan Ayah"
                                                                        value="{{ old('penggayaran_ibu') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="guardian1">
                                                        {{-- A. Guardian --}}
                                                        <div class="border-bottom p-2">
                                                            <h6 class="mt-2"><b>A. Guardian</b></h6>
                                                            <div class="form-group row">
                                                                <label for="nik_wali"
                                                                    class="col-sm-3 col-form-label required">NIK</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nik_wali" name="nik_wali" placeholder="NIK"
                                                                        value="{{ old('nik_wali') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="nama_wali"
                                                                    class="col-sm-3 col-form-label required">Nama</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nama_wali" name="nama_wali"
                                                                        placeholder="Nama" value="{{ old('nama_wali') }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="tempat_lahir_wali"
                                                                    class="col-sm-3 col-form-label">Tempat Lahir</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="tempat_lahir_wali" name="tempat_lahir_wali"
                                                                        placeholder="Tempat Lahir"
                                                                        value="{{ old('tempat_lahir_wali') }}">
                                                                </div>
                                                                <label for="tanggal_lahir_wali"
                                                                    class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                                                <div class="col-sm-3">
                                                                    <input type="date" class="form-control"
                                                                        id="tanggal_lahir_wali" name="tanggal_lahir_wali"
                                                                        placeholder="Tanggal Lahir"
                                                                        value="{{ old('tanggal_lahir_wali') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="alamat_wali"
                                                                    class="col-sm-3 col-form-label">Alamat</label>
                                                                <div class="col-sm-9">
                                                                    <textarea class="form-control" id="alamat_wali" name="alamat_wali" placeholder="Alamat">{{ old('alamat_wali') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="nomor_hp_wali"
                                                                    class="col-sm-3 col-form-label">Nomor HP</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="nomor_hp_wali" name="nomor_hp_wali"
                                                                        placeholder="Nomor HP"
                                                                        value="{{ old('nomor_hp_wali') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="agama_wali"
                                                                    class="col-sm-3 col-form-label">Agama</label>
                                                                <div class="col-sm-9">
                                                                    <select class="form-control form-select"
                                                                        id="agama_wali" name="agama_wali">
                                                                        <option selected>-- Pilih Agama --</option>
                                                                        <option value="1">Islam</option>
                                                                        <option value="2">Kristen</option>
                                                                        <option value="3">Katolik</option>
                                                                        <option value="4">Hindu</option>
                                                                        <option value="5">Budha</option>
                                                                        <option value="6">Khonghucu</option>
                                                                        <option value="7">Lainnya</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="kota_wali"
                                                                    class="col-sm-3 col-form-label">Kota</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="kota_wali" name="kota_wali"
                                                                        placeholder="Kota"
                                                                        value="{{ old('kota_wali') }}">
                                                                </div>
                                                                <label for="pendidikan_terakhir_wali"
                                                                    class="col-sm-3 col-form-label">Pendidikan
                                                                    Terakhir</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        id="pendidikan_terakhir_wali"
                                                                        name="pendidikan_terakhir_wali"
                                                                        placeholder="Pendidikan Terakhir"
                                                                        value="{{ old('pendidikan_terakhir_wali') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="pekerjaan_wali"
                                                                    class="col-sm-3 col-form-label required">Pekerjaan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="pekerjaan_wali" name="pekerjaan_wali"
                                                                        placeholder="Pekerjaan"
                                                                        value="{{ old('pekerjaan_wali') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="penghasilan_wali"
                                                                    class="col-sm-3 col-form-label">Penghasilan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="penghasilan_wali" name="penghasilan_wali"
                                                                        placeholder="Penghasilan"
                                                                        value="{{ old('penggayaran_wali') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                            <th>Name</th>
                                            <th>Level</th>
                                            <th>Class</th>
                                            <th>NIS</th>
                                            <th>NISN</th>
                                            <th>Sex</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_siswa as $siswa)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $siswa->nama_lengkap }}</td>
                                                <td>
                                                    @if ($siswa->kelas_id == null)
                                                        <span class="badge light bg-warning">Belum terdata</span>
                                                    @else
                                                        {{ $siswa->kelas->tingkatan->nama_tingkatan }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($siswa->kelas_id == null)
                                                        <span class="badge light bg-warning">Belum masuk anggota
                                                            kelas</span>
                                                    @else
                                                        {{ $siswa->kelas->nama_kelas }}
                                                    @endif
                                                </td>
                                                <td>{{ $siswa->nis }}</td>
                                                <td>{{ $siswa->nisn }}</td>
                                                <td>{{ $siswa->jenis_kelamin }}</td>
                                                <td>
                                                    @if ($siswa->user->status == true && $siswa->status == true)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Non Active</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    <!-- resources/views/admin/user.blade.php -->

                                                    @include('components.actions.delete-button', [
                                                        'route' => route('siswa.destroy', $siswa->id),
                                                        'id' => $siswa->id,
                                                        'isPermanent' => false,
                                                        'withShow' => true,
                                                        'showRoute' => route('siswa.show', $siswa->id),
                                                        'withEdit' => false,
                                                    ])
                                                </td>
                                            </tr>

                                            <!-- Modal Registrasi  -->
                                            @if ($siswa->kelas_id != null)
                                                <div class="modal fade" id="modal-registrasi{{ $siswa->id }}">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Registrasi Siswa Keluar</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-hidden="true"></button>
                                                            </div>
                                                            <form action="{{ route('siswa.registrasi') }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="callout callout-info">
                                                                        <h5>Diisi saat siswa keluar dari sekolah</h5>
                                                                        <p>Siswa yang dapat diluluskan hanyalah siswa yang
                                                                            berada pada kelas tingkat akhir pada semester
                                                                            genap.</p>
                                                                    </div>
                                                                    <input type="hidden" name="siswa_id"
                                                                        value="{{ $siswa->id }}">
                                                                    <div class="form-group row">
                                                                        <label for="nama_lengkap"
                                                                            class="col-sm-3 col-form-label">Nama
                                                                            Siswa</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control"
                                                                                id="nama_lengkap" name="nama_lengkap"
                                                                                placeholder="Nama Siswa"
                                                                                value="{{ $siswa->nama_lengkap }}"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="keluar_karena"
                                                                            class="col-sm-3 col-form-label">Keluar
                                                                            Karena</label>
                                                                        <div class="col-sm-9 pt-1">
                                                                            <select
                                                                                class="form-control form-select select2"
                                                                                name="keluar_karena" style="width: 100%;"
                                                                                required>
                                                                                <option value="">-- Pilih Jenis
                                                                                    Keluar --</option>
                                                                                @if ($siswa->kelas->tingkatan_id == $tingkatan_akhir && $siswa->kelas->tapel->semester->semester == 2)
                                                                                    <option value="Lulus">Lulus</option>
                                                                                @endif
                                                                                <option value="Mutasi">Mutasi</option>
                                                                                <option value="Dikeluarkan">Dikeluarkan
                                                                                </option>
                                                                                <option value="Mengundurkan Diri">
                                                                                    Mengundurkan Diri</option>
                                                                                <option value="Putus Sekolah">Putus Sekolah
                                                                                </option>
                                                                                <option value="Wafat">Wafat</option>
                                                                                <option value="Hilang">Hilang</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="tanggal_keluar"
                                                                            class="col-sm-3 col-form-label">Tanggal Keluar
                                                                            Sekolah</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="date" class="form-control"
                                                                                id="tanggal_keluar" name="tanggal_keluar">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label for="alasan_keluar"
                                                                            class="col-sm-3 col-form-label">Alasan
                                                                            Keluar</label>
                                                                        <div class="col-sm-9">
                                                                            <textarea class="form-control" id="alasan_keluar" name="alasan_keluar" placeholder="Alasan Keluar"></textarea>
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
                                            @endif
                                            <!-- End Modal Registrasi -->
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

@push('custom-scripts')
    <!-- pas_photo preview-->
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#pas_photo_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <!-- ajax get class id and and jurusan class name-->
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="tingkatan_id"]').on('change', function() {
                var tingkatan_id = $(this).val();
                console.log(tingkatan_id);
                if (tingkatan_id) {
                    $.ajax({
                        url: '/admin/getKelasByTingkatan/ajax/' + tingkatan_id,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('select[name="kelas_id"]').empty();
                            $('select[name="jurusan_id"]').empty();

                            $('select[name="kelas_id"]').append(
                                '<option value="">-- Select Class Name --</option>'
                            );

                            $('select[name="jurusan_id"]').append(
                                '<option value="">-- Select Level Name --</option>'
                            );

                            $.each(response.data, function(i, item) {
                                $('select[name="kelas_id"]').append(
                                    '<option value="' +
                                    item.id + '">' + item.nama_kelas + '</option>');
                            });

                            $.each(response.data_jurusan, function(i, item) {
                                $('select[name="jurusan_id"]').append(
                                    '<option value="' +
                                    item.id + '">' + item.nama_jurusan + '</option>'
                                );
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

@section('footer')
    @include('layouts.main.footer')
@endsection

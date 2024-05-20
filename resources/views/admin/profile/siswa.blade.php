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
            $dashboard = route('admin.dashboard');
        @endphp
        @include('layouts.partials.breadcrumbs._breadcrumbs-item', [
            'titleBreadCrumb' => $title,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => $dashboard,
                    ,
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => route('admin.tapel.index'),
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
                <div class="col-md-12 col-lg-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if ($siswa->pas_photo == null)
                                    <img class="profile-user-img" src="/assets/dist/img/avatar/{{ $siswa->avatar }}"
                                        alt="Avatar" style="border: none">
                                @else
                                    <img class="mb-2" src="{{ asset('storage/' . $siswa->pas_photo) }}"
                                        alt="{{ $siswa->pas_photo }}" alt="pas_photo" width="105px" height="144px">
                                @endif
                            </div>

                            <h3 class="profile-username text-center">{{ $siswa->nama_lengkap }}</h3>

                            <p class="text-muted text-center">
                                <!-- check for role in roles -->
                                @if ($siswa->user->hasRole('Admin') || $siswa->user->getRoleNames()->first())
                                    {{ $siswa->user->getRoleNames()->first() }}
                                @elseif ($siswa->user->hasRole('Student') && $siswa->positionKaryawan)
                                    {{ $siswa->positionKaryawan->position_nama }}
                                @endif
                            </p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Status</b> <a class="float-right">
                                        @if ($siswa->user->status == true && $siswa->status == true)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Non Active</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Username</b> <a class="float-right">{{ $siswa->user->username }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ $siswa->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Nomor HP</b> <a class="float-right">{{ $siswa->nomor_hp }}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-12 col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> Data Pribadi</h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
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
                                    <a href="#mother1" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
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
                                <div class="tab-pane  show active" id="student1">
                                    {{-- A. Personal Information --}}
                                    <div class="border-bottom p-2">
                                        <h6 class="mt-2"><b>A. Personal Information</b></h6>
                                        <div class="form-group row">
                                            <label for="nik" class="col-sm-3 col-form-label ">NIK</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="NIK"
                                                    value="{{ $siswa->nik }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nis" class="col-sm-3 col-form-label">NIS</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="nis" name="nis"
                                                    placeholder="NIS" value="{{ $siswa->nis }}" disabled>
                                            </div>
                                            <label for="nisn" class="col-sm-2 col-form-label">NISN</label>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" id="nisn" name="nisn"
                                                    placeholder="NISN" value="{{ $siswa->nisn }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama Siswa</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder=""
                                                    value="{{ $siswa->nama_lengkap }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama Panggilan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder=""
                                                    value="{{ $siswa->nama_panggilan }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class=" col-sm-3 col-form-label ">Tingkatan</label>
                                            <div class="col-sm-3">
                                                <select class="form-control form-select" required disabled>
                                                    <option value=""></option>
                                                    @foreach ($data_tingkatan as $tingkatan)
                                                        <option value="{{ $tingkatan->id }}"
                                                            @if ($tingkatan->id == $siswa->tingkatan_id) selected @endif>
                                                            {{ $tingkatan->nama_tingkatan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label class="col-sm-2 col-form-label ">Kelas</label>
                                            <div class="col-sm-4">
                                                <select class="form-control form-select" required disabled>
                                                    <option value=""></option>
                                                    <option value="{{ $siswa->kelas ? $siswa->kelas->id : 0 }}" selected>
                                                        {{ $siswa->kelas ? $siswa->kelas->nama_kelas : '' }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama_wali" class="col-sm-3 col-form-label ">Jenis
                                                Pendaftaran</label>
                                            <div class="col-sm-3 pt-1">
                                                <label class="form-check-label mr-3"><input type="radio"
                                                        onchange='CheckPendaftaran(this.value);' value="1"
                                                        @if ($siswa->jenis_pendaftaran == '1') checked @endif required disabled>
                                                    Siswa Baru</label>
                                                <label class="form-check-label mr-3"><input type="radio"
                                                        onchange='CheckPendaftaran(this.value);' value="2"
                                                        @if ($siswa->jenis_pendaftaran == '2') checked @endif required disabled>
                                                    Pindahan</label>
                                            </div>
                                            <label class="col-sm-2 col-form-label ">Jurusan</label>
                                            <div class="col-sm-4">
                                                <select class="form-control form-select" required disabled>
                                                    <option value=""></option>
                                                    <option
                                                        value="{{ $siswa->kelas && $siswa->kelas->jurusan ? $siswa->kelas->jurusan->id : 0 }}"
                                                        selected>
                                                        {{ $siswa->kelas && $siswa->kelas->jurusan ? $siswa->kelas->jurusan->nama_jurusan : '' }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tahun_masuk" class="col-sm-3 col-form-label required">Tahun
                                                Masuk</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control"
                                                    value="{{ $siswa->tahun_masuk }}" disabled>
                                            </div>
                                            <label for="semester_masuk" class="col-sm-2 col-form-label required">Semester
                                                Masuk</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control"
                                                    value="{{ $siswa->semester_masuk }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kelas_masuk" class="col-sm-3 col-form-label required">Kelas
                                                Masuk</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control"
                                                    value="{{ $siswa->kelas_masuk }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis
                                                Kelamin</label>
                                            <div class="col-sm-3 pt-1">
                                                <label class="form-check-label me-3"><input type="radio" value="MALE"
                                                        @if ($siswa->jenis_kelamin == 'MALE') checked @endif required disabled>
                                                    Male</label>
                                                <label class="form-check-label me-3"><input type="radio" value="FEMALE"
                                                        @if ($siswa->jenis_kelamin == 'FEMALE') checked @endif required disabled>
                                                    Female</label>
                                            </div>
                                            <label for="bloodtype" class="col-sm-2 col-form-label">Gol. Darah</label>
                                            <div class="col-sm-4">
                                                <select class="form-control form-select" name="blood_type" required
                                                    disabled>
                                                    <option value=""></option>
                                                    <option value="A"
                                                        @if ($siswa->blood_type == 'A') selected @endif>A</option>
                                                    <option value="B"
                                                        @if ($siswa->blood_type == 'B') selected @endif>B</option>
                                                    <option value="AB"
                                                        @if ($siswa->blood_type == 'AB') selected @endif>AB</option>
                                                    <option value="O"
                                                        @if ($siswa->blood_type == 'O') selected @endif>O</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control"
                                                    value="{{ $siswa->tempat_lahir }}" disabled>
                                            </div>
                                            <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal
                                                Lahir</label>
                                            <div class="col-sm-4">
                                                <input type="date" class="form-control"
                                                    value="{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="agama" class="col-sm-3 col-form-label">Agama</label>
                                            <div class="col-sm-3">
                                                <select class="form-control form-select" required disabled>
                                                    <option value=""></option>
                                                    <option value="1"
                                                        @if ($siswa->agama == '1') selected @endif>Islam</option>
                                                    <option value="2"
                                                        @if ($siswa->agama == '2') selected @endif>Protestan
                                                    </option>
                                                    <option value="3"
                                                        @if ($siswa->agama == '3') selected @endif>Katolik</option>
                                                    <option value="4"
                                                        @if ($siswa->agama == '4') selected @endif>Hindu</option>
                                                    <option value="5"
                                                        @if ($siswa->agama == '5') selected @endif>Budha</option>
                                                    <option value="6"
                                                        @if ($siswa->agama == '6') selected @endif>Khonghucu
                                                    </option>
                                                    <option value="7"
                                                        @if ($siswa->agama == '7') selected @endif>Lainnya
                                                    </option>
                                                </select>
                                            </div>
                                            <label for="warga_negara" class="col-sm-2 col-form-label">Warga Negara</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control"
                                                    value="{{ $siswa->warga_negara }}" disabled>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="jml_saudara_kandung" class="col-sm-3 col-form-label">Jumlah
                                                Saudara Kandung</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="jml_saudara_kandung"
                                                    name="jml_saudara_kandung" value="{{ $siswa->jml_saudara_kandung }}"
                                                    disabled>
                                            </div>
                                            <label for="anak_ke" class="col-sm-2 col-form-label">Anak Ke</label>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" value="{{ $siswa->anak_ke }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- B. Domicile Information --}}
                                    <div class="border-bottom mt-3 p-2">
                                        <h6 class="mt-2"><b>B. Domicile Information</b></h6>
                                        <div class="form-group row">
                                            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" placeholder="" disabled>{{ $siswa->alamat }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kota" class="col-sm-3 col-form-label">Kota</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" placeholder=""
                                                    value="{{ $siswa->kota }}" disabled>
                                            </div>
                                            <label for="kode_pos" class="col-sm-2 col-form-label">Kode Pos</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" placeholder=""
                                                    value="{{ $siswa->kode_pos }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jarak_rumah_ke_sekolah" class="col-sm-3 col-form-label">Jarak
                                                Rumah ke Sekolah (km)</label>
                                            <div class="col-sm-9">
                                                <input type="number" placeholder="" class="form-control"
                                                    value="{{ $siswa->jarak_rumah_ke_sekolah }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" placeholder=""
                                                    value="{{ $siswa->email }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email_parent" class="col-sm-3 col-form-label">Email Parent</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" placeholder=""
                                                    value="{{ $siswa->email_parent }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nomor_hp" class="col-sm-3 col-form-label">Nomor HP</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" placeholder=""
                                                    value="{{ $siswa->nomor_hp }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tinggal_bersama" class="col-sm-3 col-form-label">Tinggal
                                                Bersama</label>
                                            <div class="col-sm-4">
                                                <select class="form-control form-select" name="tinggal_bersama" disabled>
                                                    <option value=""></option>
                                                    <option value="Parents"
                                                        @if ($siswa->tinggal_bersama == 'Parents') selected @endif>Parents</option>
                                                    <option value="Others"
                                                        @if ($siswa->tinggal_bersama == 'Others') selected @endif>Others</option>
                                                </select>
                                            </div>
                                            <label for="transportasi" class="col-sm-2 col-form-label">Transportasi</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control"
                                                    value="{{ $siswa->transportasi }}" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- C. Student Medical Condition --}}
                                    <div class="border-bottom mt-3 p-2">
                                        <h6 class="mt-2"><b>C. Student Medical Condition</b></h6>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Tinggi Badan</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" placeholder=""
                                                    value="{{ $siswa->tinggi_badan }}" disabled>
                                            </div>
                                            <label class="col-sm-2 col-form-label">Berat Badan</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" placeholder=""
                                                    value="{{ $siswa->berat_badan }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Spesial Treatment</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder=""
                                                    value="{{ $siswa->spesial_treatment }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Note Kesehatan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder=""
                                                    value="{{ $siswa->note_kesehatan }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">File Document Kesehatan</label>
                                            <div class="col-sm-9 custom-file">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        @if (isset($siswa->file_document_kesehatan))
                                                            <a href="/storage/{{ $siswa->file_document_kesehatan }}"
                                                                class="badge bg-info badge-sm" target="_blank"><i
                                                                    class="nav-icon fas fa-download"></i> &nbsp; Dokument
                                                                Kesehatan</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">File List Pertanyaan</label>
                                            <div class="col-sm-9 custom-file">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        @if (isset($siswa->file_list_pertanyaan))
                                                            <a href="/storage/{{ $siswa->file_list_pertanyaan }}"
                                                                class="badge bg-info badge-sm" target="_blank"><i
                                                                    class="nav-icon fas fa-download"></i> &nbsp; Dokument
                                                                List Pertanyaan</a>
                                                        @endif
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
                                            <label class="col-sm-3 col-form-label">NIK</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="NIK"
                                                    value="{{ $siswa->nik_ayah }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama_ayah" class="col-sm-3 col-form-label">Nama</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Nama"
                                                    value="{{ $siswa->nama_ayah }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Tempat Lahir</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" placeholder="Tempat Lahir"
                                                    value="{{ $siswa->tempat_lahir_ayah }}" disabled>
                                            </div>
                                            <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" placeholder="Tanggal Lahir"
                                                    value="{{ $siswa->tanggal_lahir_ayah ? \Carbon\Carbon::parse($siswa->tanggal_lahir_ayah)->format('Y-m-d') : '' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Alamat</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" placeholder="Alamat" disabled>{{ $siswa->alamat_ayah }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nomor HP</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Nomor HP"
                                                    value="{{ $siswa->nomor_hp_ayah }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Agama</label>
                                            <div class="col-sm-9">
                                                <select class="form-control form-select" disabled>
                                                    <option selected>-- Pilih Agama --</option>
                                                    <option value="1"
                                                        @if ($siswa->agama_ayah == 1) selected @endif>Islam</option>
                                                    <option value="2"
                                                        @if ($siswa->agama_ayah == 2) selected @endif>Kristen</option>
                                                    <option value="3"
                                                        @if ($siswa->agama_ayah == 3) selected @endif>Katolik</option>
                                                    <option value="4"
                                                        @if ($siswa->agama_ayah == 4) selected @endif>Hindu</option>
                                                    <option value="5"
                                                        @if ($siswa->agama_ayah == 5) selected @endif>Budha</option>
                                                    <option value="6"
                                                        @if ($siswa->agama_ayah == 6) selected @endif>Khonghucu
                                                    </option>
                                                    <option value="7"
                                                        @if ($siswa->agama_ayah == 7) selected @endif>Lainnya
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kota_ayah" class="col-sm-3 col-form-label">Kota</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" placeholder="Kota"
                                                    value="{{ $siswa->kota_ayah }}" disabled>
                                            </div>
                                            <label for="pendidikan_terakhir_ayah"
                                                class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control"
                                                    placeholder="Pendidikan Terakhir"
                                                    value="{{ $siswa->pendidikan_terakhir_ayah }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pekerjaan_ayah" class="col-sm-3 col-form-label">Pekerjaan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Pekerjaan"
                                                    value="{{ $siswa->pekerjaan_ayah }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="penghasil_ayah"
                                                class="col-sm-3 col-form-label">Penghasilan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Penghasilan"
                                                    value="{{ $siswa->penghasil_ayah }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="mother1">
                                    {{-- A. Mother --}}
                                    <div class="border-bottom p-2">
                                        <h6 class="mt-2"><b>A. Mother</b></h6>
                                        <div class="form-group row">
                                            <label for="nik_ibu" class="col-sm-3 col-form-label">NIK</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="NIK"
                                                    value="{{ $siswa->nik_ibu }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama_ayah" class="col-sm-3 col-form-label">Nama</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Nama"
                                                    value="{{ $siswa->nama_ibu }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Tempat Lahir</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" placeholder="Tempat Lahir"
                                                    value="{{ $siswa->tempat_lahir_ibu }}" disabled>
                                            </div>
                                            <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" placeholder="Tanggal Lahir"
                                                    value="{{ $siswa->tanggal_lahir_ibu ? \Carbon\Carbon::parse($siswa->tanggal_lahir_ibu)->format('Y-m-d') : '' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Alamat</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" placeholder="Alamat" disabled>{{ $siswa->alamat_ibu }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nomor HP</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Nomor HP"
                                                    value="{{ $siswa->nomor_hp_ibu }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Agama</label>
                                            <div class="col-sm-9">
                                                <select class="form-control form-select" disabled>
                                                    <option selected>-- Pilih Agama --</option>
                                                    <option value="1"
                                                        @if ($siswa->agama_ibu == '1') selected @endif>Islam</option>
                                                    <option value="2"
                                                        @if ($siswa->agama_ibu == '2') selected @endif>Kristen</option>
                                                    <option value="3"
                                                        @if ($siswa->agama_ibu == '3') selected @endif>Katolik</option>
                                                    <option value="4"
                                                        @if ($siswa->agama_ibu == '4') selected @endif>Hindu</option>
                                                    <option value="5"
                                                        @if ($siswa->agama_ibu == '5') selected @endif>Budha</option>
                                                    <option value="6"
                                                        @if ($siswa->agama_ibu == '6') selected @endif>Khonghucu
                                                    </option>
                                                    <option value="7"
                                                        @if ($siswa->agama_ibu == '7') selected @endif>Lainnya
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kota</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" placeholder="Kota"
                                                    value="{{ $siswa->kota_ibu }}" disabled>
                                            </div>
                                            <label class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control"
                                                    placeholder="Pendidikan Terakhir"
                                                    value="{{ $siswa->pendidikan_terakhir_ibu }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Pekerjaan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Pekerjaan Ayah"
                                                    value="{{ $siswa->pekerjaan_ibu }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="penghasil_ibu" class="col-sm-3 col-form-label">Penghasilan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Penghasilan"
                                                    value="{{ $siswa->penghasil_ibu }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="guardian1">
                                    {{-- A. Guardian --}}
                                    <div class="border-bottom p-2">
                                        <h6 class="mt-2"><b>A. Guardian</b></h6>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">NIK</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="NIK"
                                                    value="{{ $siswa->nik_wali }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Nama"
                                                    value="{{ $siswa->nama_wali }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Tempat Lahir</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" placeholder="Tempat Lahir"
                                                    value="{{ $siswa->tempat_lahir_wali }}" disabled>
                                            </div>
                                            <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" placeholder="Tanggal Lahir"
                                                    value="{{ date('d-m-Y', strtotime($siswa->tanggal_lahir_wali)) }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Alamat</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" placeholder="Alamat" disabled>{{ $siswa->alamat_wali }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nomor HP</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Nomor HP"
                                                    value="{{ $siswa->nomor_hp_wali }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Agama</label>
                                            <div class="col-sm-9">
                                                <select class="form-control form-select" disabled>
                                                    <option selected>-- Pilih Agama --</option>
                                                    <option value="1"
                                                        @if ($siswa->agama_wali == '1') selected @endif>Islam</option>
                                                    <option value="2"
                                                        @if ($siswa->agama_wali == '2') selected @endif>Kristen</option>
                                                    <option value="3"
                                                        @if ($siswa->agama_wali == '3') selected @endif>Katolik</option>
                                                    <option value="4"
                                                        @if ($siswa->agama_wali == '4') selected @endif>Hindu</option>
                                                    <option value="5"
                                                        @if ($siswa->agama_wali == '5') selected @endif>Budha</option>
                                                    <option value="6"
                                                        @if ($siswa->agama_wali == '6') selected @endif>Khonghucu
                                                    </option>
                                                    <option value="7"
                                                        @if ($siswa->agama_wali == '7') selected @endif>Lainnya
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kota</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" placeholder="Kota"
                                                    value="{{ $siswa->kota_wali }}" disabled>
                                            </div>
                                            <label class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control"
                                                    placeholder="Pendidikan Terakhir"
                                                    value="{{ $siswa->pendidikan_terakhir_wali }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Pekerjaan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Pekerjaan"
                                                    value="{{ $siswa->pekerjaan_wali }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Penghasilan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Penghasilan"
                                                    value="{{ $siswa->penghasil_wali }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modal-edit{{ $siswa->id }}">Edit</button>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->

                <!-- Modal edit  -->
                <div class="modal fade" id="modal-edit{{ $siswa->id }}">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit {{ $title }}</h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                                </button>
                            </div>
                            <form action="{{ route('profilesiswa.update', $siswa->id) }}" method="POST"
                                enctype="multipart/form-data">
                                {{ method_field('PATCH') }}
                                @csrf
                                <div class="modal-body">
                                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                        <li class="nav-item">
                                            <a href="#student2" data-bs-toggle="tab" aria-expanded="false"
                                                class="nav-link rounded-0 active">
                                                <i class="mdi mdi-home-variant d-lg-none d-block me-1"></i>
                                                <span class="d-none d-lg-block">Student</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#father2" data-bs-toggle="tab" aria-expanded="true"
                                                class="nav-link rounded-0 ">
                                                <i class="mdi mdi-account-circle d-lg-none d-block me-1"></i>
                                                <span class="d-none d-lg-block">Father</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#mother2" data-bs-toggle="tab" aria-expanded="true"
                                                class="nav-link rounded-0">
                                                <i class="mdi mdi-account-circle d-lg-none d-block me-1"></i>
                                                <span class="d-none d-lg-block">Mother</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#guardian2" data-bs-toggle="tab" aria-expanded="false"
                                                class="nav-link rounded-0">
                                                <i class="mdi mdi-settings-outline d-lg-none d-block me-1"></i>
                                                <span class="d-none d-lg-block">Guardian</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="student2">

                                            <div class="border-bottom p-2">
                                                <h6 class="mt-2"><b>Authentication User</b></h6>
                                                {{-- username --}}
                                                <div class="form-group row">
                                                    <label for="username"
                                                        class="col-sm-3 col-form-label ">Username</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="username"
                                                            name="username" placeholder="Username"
                                                            value="{{ $siswa->user->username }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="password_lama" class="col-sm-3 col-form-label">Password
                                                        Lama</label>
                                                    <div class="col-sm-3">
                                                        <input type="password" class="form-control" id="password_lama"
                                                            name="password_lama" placeholder="Password Lama"
                                                            value="">
                                                    </div>
                                                    <label for="password_baru" class="col-sm-2 col-form-label ">Password
                                                        Baru</label>
                                                    <div class="col-sm-4">
                                                        <input type="password" class="form-control" id="password_baru"
                                                            name="password_baru" placeholder="Password Baru"
                                                            value="">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- A. Personal Information --}}
                                            <div class="border-bottom p-2">
                                                <h6 class="mt-2"><b>A. Personal Information</b></h6>
                                                <div class="form-group row">
                                                    <label for="nik"
                                                        class="col-sm-3 col-form-label required">NIK</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="nik"
                                                            name="nik" placeholder="NIK" value="{{ $siswa->nik }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nis"
                                                        class="col-sm-3 col-form-label required">NIS</label>
                                                    <div class="col-sm-3">
                                                        <input type="number" class="form-control" id="nis"
                                                            name="nis" placeholder="NIS" value="{{ $siswa->nis }}"
                                                            disabled>
                                                    </div>
                                                    <label for="nisn" class="col-sm-2 col-form-label">NISN</label>
                                                    <div class="col-sm-4">
                                                        <input type="number" class="form-control" id="nisn"
                                                            name="nisn" placeholder="NISN"
                                                            value="{{ $siswa->nisn }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="nama_lengkap"
                                                        class="col-sm-3 col-form-label required">Nama Siswa</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="nama_lengkap"
                                                            name="nama_lengkap" placeholder="Nama Siswa"
                                                            value="{{ $siswa->nama_lengkap }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nama_panggilan"
                                                        class="col-sm-3 col-form-label required">Nama Panggilan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="nama_panggilan"
                                                            name="nama_panggilan" placeholder="Nama Panggilan"
                                                            value="{{ $siswa->nama_panggilan }}" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class=" col-sm-3 col-form-label required">Tingkatan</label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control form-select" id="kelas"
                                                            name="tingkatan_id" disabled>
                                                            <option value="">-- Pilih Tingkatan --</option>
                                                            @foreach ($data_tingkatan as $tingkatan)
                                                                <option value="{{ $tingkatan->id }}"
                                                                    @if ($tingkatan->id == $siswa->tingkatan_id) selected @endif>
                                                                    {{ $tingkatan->nama_tingkatan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label class="col-sm-2 col-form-label required">Kelas</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control form-select" required disabled>
                                                            <option value=""></option>
                                                            <option value="{{ $siswa->kelas ? $siswa->kelas->id : 0 }}"
                                                                selected>
                                                                {{ $siswa->kelas ? $siswa->kelas->nama_kelas : '' }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="nama_wali" class="col-sm-3 col-form-label required">Jenis
                                                        Pendaftaran</label>
                                                    <div class="col-sm-3 pt-1">
                                                        <label class="form-check-label me-3"><input type="radio"
                                                                name="jenis_pendaftaran"
                                                                onchange='CheckPendaftaran(this.value);' value="1"
                                                                @if ($siswa->jenis_pendaftaran == '1') checked @endif disabled>
                                                            Siswa Baru</label>
                                                        <label class="form-check-label me-3"><input type="radio"
                                                                name="jenis_pendaftaran"
                                                                onchange='CheckPendaftaran(this.value);' value="2"
                                                                @if ($siswa->jenis_pendaftaran == '2') checked @endif disabled>
                                                            Pindahan</label>
                                                    </div>
                                                    <label class="col-sm-2 col-form-label required">Jurusan</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control form-select" id="jurusan_id"
                                                            name="jurusan_id" disabled>
                                                            <option value="">-- Pilih Kelas --</option>
                                                            @if ($siswa->kelas)
                                                                <option value="{{ $siswa->kelas->jurusan->id }}" selected>
                                                                    {{ $siswa->kelas->jurusan->nama_jurusan }}
                                                                </option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tahun_masuk"
                                                        class="col-sm-3 col-form-label required">Tahun Masuk</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="tahun_masuk" id="tahun_masuk"
                                                            class="form-control" value="{{ $siswa->tahun_masuk }}"
                                                            disabled>
                                                    </div>
                                                    <label for="semester_masuk"
                                                        class="col-sm-2 col-form-label required">Semester Masuk</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="semester_masuk" id="semester_masuk"
                                                            class="form-control" value="{{ $siswa->semester_masuk }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="kelas_masuk"
                                                        class="col-sm-3 col-form-label required">Kelas Masuk</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="kelas_masuk" id="kelas_masuk"
                                                            class="form-control" value="{{ $siswa->kelas_masuk }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="jenis_kelamin"
                                                        class="col-sm-3 col-form-label required">Jenis Kelamin</label>
                                                    <div class="col-sm-3 pt-1">
                                                        <label class="form-check-label me-3"><input type="radio"
                                                                name="jenis_kelamin" value="MALE"
                                                                @if ($siswa->jenis_kelamin == 'MALE') checked @endif required>
                                                            Male</label>
                                                        <label class="form-check-label me-3"><input type="radio"
                                                                name="jenis_kelamin" value="FEMALE"
                                                                @if ($siswa->jenis_kelamin == 'FEMALE') checked @endif required>
                                                            Female</label>
                                                    </div>
                                                    <label for="bloodtype" class="col-sm-2 col-form-label">Gol.
                                                        Darah</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control form-select" name="blood_type">
                                                            <option value="">-- Pilih Gol. Darah --</option>
                                                            <option value="A"
                                                                @if ($siswa->blood_type == 'A') selected @endif>A
                                                            </option>
                                                            <option value="B"
                                                                @if ($siswa->blood_type == 'B') selected @endif>B
                                                            </option>
                                                            <option value="AB"
                                                                @if ($siswa->blood_type == 'AB') selected @endif>AB
                                                            </option>
                                                            <option value="O"
                                                                @if ($siswa->blood_type == 'O') selected @endif>O
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tempat_lahir"
                                                        class="col-sm-3 col-form-label required">Tempat Lahir</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="tempat_lahir"
                                                            name="tempat_lahir" placeholder="Tempat Lahir"
                                                            value="{{ $siswa->tempat_lahir }} " required>
                                                    </div>
                                                    <label for="tanggal_lahir_edit"
                                                        class="col-sm-2 col-form-label required">Tanggal Lahir</label>
                                                    <div class="col-sm-4">
                                                        <input type="date" class="form-control"
                                                            id="tanggal_lahir_edit" name="tanggal_lahir"
                                                            value="{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '' }}" " required>
                                                                                                                                              </div>
                                                                                                                                            </div>

                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="agama" class="col-sm-3 col-form-label required">Agama</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <select class="form-control form-select" name="agama" required>
                                                                                                                                                  <option value="">-- Pilih Agama --</option>
                                                                                                                                                  <option value="1" @if ($siswa->agama == '1') selected @endif>Islam</option>
                                                                                                                                                  <option value="2" @if ($siswa->agama == '2') selected @endif>Protestan</option>
                                                                                                                                                  <option value="3" @if ($siswa->agama == '3') selected @endif>Katolik</option>
                                                                                                                                                  <option value="4" @if ($siswa->agama == '4') selected @endif>Hindu</option>
                                                                                                                                                  <option value="5" @if ($siswa->agama == '5') selected @endif>Budha</option>
                                                                                                                                                  <option value="6" @if ($siswa->agama == '6') selected @endif>Khonghucu</option>
                                                                                                                                                  <option value="7" @if ($siswa->agama == '7') selected @endif>Lainnya</option>
                                                                                                                                                </select>
                                                                                                                                              </div>
                                                                                                                                              <label for="warga_negara" class="col-sm-2 col-form-label">Warga Negara</label>
                                                                                                                                              <div class="col-sm-4">
                                                                                                                                                <input type="text" class="form-control" id="warga_negara" name="warga_negara" placeholder="Kewarganegaraan" value="{{ $siswa->warga_negara }}" >
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                        
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="jml_saudara_kandung" class="col-sm-3 col-form-label">Jumlah Saudara Kandung</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="number" class="form-control" id="jml_saudara_kandung" name="jml_saudara_kandung"  value="{{ $siswa->jml_saudara_kandung }}" >
                                                                                                                                              </div>
                                                                                                                                              <label for="anak_ke" class="col-sm-2 col-form-label">Anak Ke</label>
                                                                                                                                              <div class="col-sm-4">
                                                                                                                                                <input type="number" class="form-control" id="anak_ke" name="anak_ke"  value="{{ $siswa->anak_ke }}" >
                                                                                                                                              </div>
                                                                                                                                            </div>

                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="pas_photo" class="col-sm-3 col-form-label required">Pas Photo</label>
                                                                                                                                              <div class="col-sm-4 custom-file">
                                                                                                                                                <div class="input-group">
                                                                                                                                                    <div class="custom-file">
                                                                                                                                                        <input type="file" name="pas_photo" class="custom-file-input form-control form-control" id="pas_photo" onchange="readURL(this);" >
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                              </div>
                                                                                                                                              <div class="col-sm-5">
                                                                                                                                                <img src="{{ $siswa->pas_photo ? asset('storage/' . $siswa->pas_photo) : asset('assets/dist/img/3x4.png') }}" alt="" id="pas_photo_preview" width="105px" height="144px">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                          </div>

                                                                                                                                          {{-- B. Domicile Information --}}
                                                                                                                                          <div class="border-bottom mt-3 p-2" >
                                                                                                                                            <h6 class="mt-2"><b>B. Domicile Information</b></h6>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat lengkap">{{ $siswa->alamat }}</textarea>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="kota" class="col-sm-3 col-form-label">Kota</label>
                                                                                                                                              <div class="col-sm-4">
                                                                                                                                                <input type="text" class="form-control" id="kota" name="kota" placeholder="Kota" value="{{ $siswa->kota }}">
                                                                                                                                              </div>
                                                                                                                                              <label for="kode_pos" class="col-sm-2 col-form-label">Kode Pos</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="number" class="form-control" id="kode_pos" name="kode_pos" placeholder="Kode Pos" value="{{ $siswa->kode_pos }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="jarak_rumah_ke_sekolah" class="col-sm-3 col-form-label">Jarak Rumah ke Sekolah (km)</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="number" name="jarak_rumah_ke_sekolah" id="jarak_rumah_ke_sekolah" placeholder="Jarak Rumah ke Sekola (km)" class="form-control" value="{{ $siswa->jarak_rumah_ke_sekolah }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="email" class="col-sm-3 col-form-label">Email</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $siswa->email }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="email_parent" class="col-sm-3 col-form-label">Email Parent</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="email" class="form-control" id="email_parent" name="email_parent" placeholder="Email Parent" value="{{ $siswa->email_parent }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="nomor_hp" class="col-sm-3 col-form-label">Nomor HP</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="number" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Nomor HP" value="{{ $siswa->nomor_hp }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="tinggal_bersama" class="col-sm-3 col-form-label">Tinggal Bersama</label>
                                                                                                                                              <div class="col-sm-4">
                                                                                                                                                <select class="form-control form-select" name="tinggal_bersama">
                                                                                                                                                  <option value="">-- Pilih Tinggal Bersama --</option>
                                                                                                                                                  <option value="Parents" @if ($siswa->tinggal_bersama == 'Parents') selected @endif>Parents</option>
                                                                                                                                                  <option value="Others" @if ($siswa->tinggal_bersama == 'Others') selected @endif>Others</option>
                                                                                                                                                </select>
                                                                                                                                              </div>
                                                                                                                                              <label for="transportasi" class="col-sm-2 col-form-label">Transportasi</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="text" class="form-control" id="transportasi" name="transportasi" placeholder="Transportasi" value="{{ old('transportasi') }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                          </div>
                                                                                                                                          
                                                                                                                                          {{-- C. Student Medical Condition --}}
                                                                                                                                          <div class="border-bottom mt-3 p-2" >
                                                                                                                                            <h6 class="mt-2"><b>C. Student Medical Condition</b></h6>

                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="tinggi_badan" class="col-sm-3 col-form-label">Tinggi Badan</label>
                                                                                                                                              <div class="col-sm-4">
                                                                                                                                                <input type="text" class="form-control" id="tinggi_badan" name="tinggi_badan" placeholder="Tinggi Badan" value="{{ $siswa->tinggi_badan }}">
                                                                                                                                              </div>
                                                                                                                                              <label for="berat_badan" class="col-sm-2 col-form-label">Berat Badan</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="text" class="form-control" id="berat_badan" name="berat_badan" placeholder="Berat Badan" value="{{ $siswa->berat_badan }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="spesial_treatment" class="col-sm-3 col-form-label">Spesial Treatment</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="spesial_treatment" name="spesial_treatment" placeholder="Spesial Treatment" value="{{ $siswa->spesial_treatment }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="note_kesehatan" class="col-sm-3 col-form-label">Note Kesehatan</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="note_kesehatan" name="note_kesehatan" placeholder="Note Kesehatan" value="{{ $siswa->note_kesehatan }}">
                                                                                                                                              </div>
                                                                                                                                            </div>

                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="file_document_kesehatan" class="col-sm-3 col-form-label">File Document Kesehatan</label>
                                                                                                                                              <div class="col-sm-9 custom-file">
                                                                                                                                                <div class="input-group">
                                                                                                                                                    <div class="custom-file">
                                                                                                                                                        <input type="file" name="file_document_kesehatan" class="custom-file-input form-control form-control" id="file_document_kesehatan">
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="file_list_pertanyaan" class="col-sm-3 col-form-label">File List Pertanyaan</label>
                                                                                                                                              <div class="col-sm-9 custom-file">
                                                                                                                                                <div class="input-group">
                                                                                                                                                    <div class="custom-file">
                                                                                                                                                        <input type="file" name="file_list_pertanyaan" class="custom-file-input form-control form-control" id="file_list_pertanyaan">
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                          </div>

                                                                                                                                         
                                                                                                                                        </div>
                                                                                                                                        <div class="tab-pane" id="father2">
                                                                                                                                          {{-- A. Father --}}
                                                                                                                                          <div class="border-bottom p-2">
                                                                                                                                            <h6 class="mt-2"><b>A. Father</b></h6>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="nik_ayah" class="col-sm-3 col-form-label required">NIK</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="nik_ayah" name="nik_ayah" placeholder="NIK" value="{{ $siswa->nik_ayah }}" required>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="nama_ayah" class="col-sm-3 col-form-label required">Nama</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Nama" value="{{ $siswa->nama_ayah }}" required>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="tempat_lahir_ayah" class="col-sm-3 col-form-label">Tempat Lahir</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="text" class="form-control" id="tempat_lahir_ayah" name="tempat_lahir_ayah" placeholder="Tempat Lahir" value="{{ $siswa->tempat_lahir_ayah }}">
                                                                                                                                              </div>
                                                                                                                                              <label for="tanggal_lahir_ayah" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="date" class="form-control" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" placeholder="Tanggal Lahir" value="{{ $siswa->tanggal_lahir_ayah ? \Carbon\Carbon::parse($siswa->tanggal_lahir_ayah)->format('Y-m-d') : '' }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="alamat_ayah" class="col-sm-3 col-form-label">Alamat</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <textarea class="form-control" id="alamat_ayah" name="alamat_ayah" placeholder="Alamat">{{ $siswa->alamat_ayah }}</textarea>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="nomor_hp_ayah" class="col-sm-3 col-form-label">Nomor HP</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="nomor_hp_ayah" name="nomor_hp_ayah" placeholder="Nomor HP" value="{{ $siswa->nomor_hp_ayah }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="agama_ayah" class="col-sm-3 col-form-label">Agama</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <select class="form-control form-select" id="agama_ayah" name="agama_ayah">
                                                                                                                                                  <option selected>-- Pilih Agama --</option>
                                                                                                                                                  <option value="1" @if ($siswa->agama_ayah == 1) selected @endif>Islam</option>
                                                                                                                                                  <option value="2" @if ($siswa->agama_ayah == 2) selected @endif>Kristen</option>
                                                                                                                                                  <option value="3" @if ($siswa->agama_ayah == 3) selected @endif>Katolik</option>
                                                                                                                                                  <option value="4" @if ($siswa->agama_ayah == 4) selected @endif>Hindu</option>
                                                                                                                                                  <option value="5" @if ($siswa->agama_ayah == 5) selected @endif>Budha</option>
                                                                                                                                                  <option value="6" @if ($siswa->agama_ayah == 6) selected @endif>Khonghucu</option>
                                                                                                                                                  <option value="7" @if ($siswa->agama_ayah == 7) selected @endif>Lainnya</option>
                                                                                                                                                </select>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="kota_ayah" class="col-sm-3 col-form-label">Kota</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="text" class="form-control" id="kota_ayah" name="kota_ayah" placeholder="Kota" value="{{ $siswa->kota_ayah }}">
                                                                                                                                              </div>
                                                                                                                                              <label for="pendidikan_terakhir_ayah" class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="text" class="form-control" id="pendidikan_terakhir_ayah" name="pendidikan_terakhir_ayah" placeholder="Pendidikan Terakhir" value="{{ $siswa->pendidikan_terakhir_ayah }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="pekerjaan_ayah" class="col-sm-3 col-form-label required">Pekerjaan</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" placeholder="Pekerjaan" value="{{ $siswa->pekerjaan_ayah }}" required>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="penghasil_ayah" class="col-sm-3 col-form-label">Penghasilan</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="penghasil_ayah" name="penghasil_ayah" placeholder="Penghasilan" value="{{ $siswa->penghasil_ayah }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                          </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="tab-pane" id="mother2">
                                                                                                                                          {{-- A. Mother --}}
                                                                                                                                          <div class="border-bottom p-2">
                                                                                                                                            <h6 class="mt-2"><b>A. Mother</b></h6>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="nik_ibu" class="col-sm-3 col-form-label required">NIK</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="nik_ibu" name="nik_ibu" placeholder="NIK" value="{{ $siswa->nik_ibu }}" required>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="nama_ayah" class="col-sm-3 col-form-label required">Nama</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Nama" value="{{ $siswa->nama_ibu }}" required>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="tempat_lahir_ibu" class="col-sm-3 col-form-label">Tempat Lahir</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="text" class="form-control" id="tempat_lahir_ibu" name="tempat_lahir_ibu" placeholder="Tempat Lahir" value="{{ $siswa->tempat_lahir_ibu }}">
                                                                                                                                              </div>
                                                                                                                                              <label for="tanggal_lahir_ibu" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="date" class="form-control" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" placeholder="Tanggal Lahir" value="{{ $siswa->tanggal_lahir_ibu ? \Carbon\Carbon::parse($siswa->tanggal_lahir_ibu)->format('Y-m-d') : '' }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="alamat_ibu" class="col-sm-3 col-form-label">Alamat</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <textarea class="form-control" id="alamat_ibu" name="alamat_ibu" placeholder="Alamat">{{ $siswa->alamat_ibu }}</textarea>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="nomor_hp_ibu" class="col-sm-3 col-form-label">Nomor HP</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="nomor_hp_ibu" name="nomor_hp_ibu" placeholder="Nomor HP" value="{{ $siswa->nomor_hp_ibu }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="agama_ibu" class="col-sm-3 col-form-label">Agama</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <select class="form-control form-select" id="agama_ibu" name="agama_ibu">
                                                                                                                                                  <option selected>-- Pilih Agama --</option>
                                                                                                                                                  <option value="1" @if ($siswa->agama_ibu == '1') selected @endif>Islam</option>
                                                                                                                                                  <option value="2" @if ($siswa->agama_ibu == '2') selected @endif>Kristen</option>
                                                                                                                                                  <option value="3" @if ($siswa->agama_ibu == '3') selected @endif>Katolik</option>
                                                                                                                                                  <option value="4" @if ($siswa->agama_ibu == '4') selected @endif>Hindu</option>
                                                                                                                                                  <option value="5" @if ($siswa->agama_ibu == '5') selected @endif>Budha</option>
                                                                                                                                                  <option value="6" @if ($siswa->agama_ibu == '6') selected @endif>Khonghucu</option>
                                                                                                                                                  <option value="7" @if ($siswa->agama_ibu == '7') selected @endif>Lainnya</option>
                                                                                                                                                </select>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="kota_ibu" class="col-sm-3 col-form-label">Kota</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="text" class="form-control" id="kota_ibu" name="kota_ibu" placeholder="Kota" value="{{ $siswa->kota_ibu }}">
                                                                                                                                              </div>
                                                                                                                                              <label for="pendidikan_terakhir_ibu" class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="text" class="form-control" id="pendidikan_terakhir_ibu" name="pendidikan_terakhir_ibu" placeholder="Pendidikan Terakhir" value="{{ $siswa->pendidikan_terakhir_ibu }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="pekerjaan_ibu" class="col-sm-3 col-form-label required">Pekerjaan</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" placeholder="Pekerjaan Ayah" value="{{ $siswa->pekerjaan_ibu }}" required>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="penghasil_ibu" class="col-sm-3 col-form-label">Penghasilan</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="penghasil_ibu" name="penghasil_ibu" placeholder="Penghasilan" value="{{ $siswa->penghasil_ibu }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                          </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="tab-pane" id="guardian2">
                                                                                                                                          {{-- A. Guardian --}}
                                                                                                                                          <div class="border-bottom p-2">
                                                                                                                                            <h6 class="mt-2"><b>A. Guardian</b></h6>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="nik_wali" class="col-sm-3 col-form-label required">NIK</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="nik_wali" name="nik_wali" placeholder="NIK" value="{{ $siswa->nik_wali }}" required>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="nama_wali" class="col-sm-3 col-form-label required">Nama</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="nama_wali" name="nama_wali" placeholder="Nama" value="{{ $siswa->nama_wali }}" required>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="tempat_lahir_wali" class="col-sm-3 col-form-label">Tempat Lahir</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="text" class="form-control" id="tempat_lahir_wali" name="tempat_lahir_wali" placeholder="Tempat Lahir" value="{{ $siswa->tempat_lahir_wali }}">
                                                                                                                                              </div>
                                                                                                                                              <label for="tanggal_lahir_wali" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="date" class="form-control" id="tanggal_lahir_wali" name="tanggal_lahir_wali" placeholder="Tanggal Lahir" value="{{ $siswa->tanggal_lahir_wali ? \Carbon\Carbon::parse($siswa->tanggal_lahir_wali)->format('Y-m-d') : '' }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="alamat_wali" class="col-sm-3 col-form-label">Alamat</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <textarea class="form-control" id="alamat_wali" name="alamat_wali" placeholder="Alamat">{{ $siswa->alamat_wali }}</textarea>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="nomor_hp_wali" class="col-sm-3 col-form-label">Nomor HP</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="nomor_hp_wali" name="nomor_hp_wali" placeholder="Nomor HP" value="{{ $siswa->nomor_hp_wali }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="agama_wali" class="col-sm-3 col-form-label">Agama</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <select class="form-control form-select" id="agama_wali" name="agama_wali">
                                                                                                                                                  <option selected>-- Pilih Agama --</option>
                                                                                                                                                  <option value="1" @if ($siswa->agama_wali == '1') selected @endif>Islam</option>
                                                                                                                                                  <option value="2" @if ($siswa->agama_wali == '2') selected @endif>Kristen</option>
                                                                                                                                                  <option value="3" @if ($siswa->agama_wali == '3') selected @endif>Katolik</option>
                                                                                                                                                  <option value="4" @if ($siswa->agama_wali == '4') selected @endif>Hindu</option>
                                                                                                                                                  <option value="5" @if ($siswa->agama_wali == '5') selected @endif>Budha</option>
                                                                                                                                                  <option value="6" @if ($siswa->agama_wali == '6') selected @endif>Khonghucu</option>
                                                                                                                                                  <option value="7" @if ($siswa->agama_wali == '7') selected @endif>Lainnya</option>
                                                                                                                                                </select>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="kota_wali" class="col-sm-3 col-form-label">Kota</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="text" class="form-control" id="kota_wali" name="kota_wali" placeholder="Kota" value="{{ $siswa->kota_wali }}">
                                                                                                                                              </div>
                                                                                                                                              <label for="pendidikan_terakhir_wali" class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                                                                                                                                              <div class="col-sm-3">
                                                                                                                                                <input type="text" class="form-control" id="pendidikan_terakhir_wali" name="pendidikan_terakhir_wali" placeholder="Pendidikan Terakhir" value="{{ $siswa->pendidikan_terakhir_wali }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="pekerjaan_wali" class="col-sm-3 col-form-label required">Pekerjaan</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="pekerjaan_wali" name="pekerjaan_wali" placeholder="Pekerjaan" value="{{ $siswa->pekerjaan_wali }}" required>
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group row">
                                                                                                                                              <label for="penghasil_wali" class="col-sm-3 col-form-label">Penghasilan</label>
                                                                                                                                              <div class="col-sm-9">
                                                                                                                                                <input type="text" class="form-control" id="penghasil_wali" name="penghasil_wali" placeholder="Penghasilan" value="{{ $siswa->penghasil_wali }}">
                                                                                                                                              </div>
                                                                                                                                            </div>
                                                                                                                                          </div>
                                                                                                                                        </div>
                                                                                                                                      </div>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-footer justify-content-end">
                                                                                                                                      <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                                                                                                                                      <button type="submit" class="btn btn-primary">Simpan</button>
                                                                                                                                    </div>
                                                                                                                                  </form>
                                                                                                                                </div>
                                                                                                                              </div>
                                                                                                                            </div>
                                                                                                                            <!-- End Modal edit -->
                                                                                                                </div>
                                                                                                                <!-- /.row -->

                                                                                                            </div>
                                                                                                            <!-- ============================================================== -->
                                                                                                            <!-- End Container fluid  -->
                                                                                                            <!-- ============================================================== -->
                                                                                                        </div>
@endsection

                                        @push('custom-scripts')
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
                                                                                                                            url: '/getKelasByTingkatan/ajax/' + tingkatan_id,
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

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
                    'title' => 'Profile',
                    'url' => route('profile'),
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
                <div class="col-md-12 col-lg-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if (optional($karyawan)->pas_photo == null)
                                    <img class="profile-user-img" src="{{ asset('assets/dist/img/avatar/default.png') }}"
                                        alt="Default Avatar" style="border: none">
                                @else
                                    <img class="mb-2"
                                        src="{{ optional($karyawan)->pas_photo ? asset('storage/' . $karyawan->pas_photo) : 'fallback_image.jpg' }}"
                                        alt="{{ optional($karyawan)->pas_photo }}" alt="pas_photo" width="105px"
                                        height="144px">
                                @endif
                            </div>

                            <h3 class="profile-username text-center">{{ $karyawan->nama_lengkap }}</h3>

                            <p class="text-muted text-center">
                                <!-- check for role in roles -->
                                @if ($karyawan->user->role == '1')
                                    Admin
                                @elseif($karyawan->user->role == '2')
                                    {{ $karyawan->positionKaryawan->position_nama }}
                                @elseif($karyawan->user->role == '3')
                                    Siswa
                                @endif
                            </p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Status</b> <a class="float-right">
                                        @if ($karyawan->user->status == true && $karyawan->status == true)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Non Active</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Username</b> <a class="float-right">{{ $karyawan->user->username }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ $karyawan->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Nomor HP</b> <a class="float-right">{{ $karyawan->nomor_hp }}</a>
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
                            <h3 class="card-title"> Detail Karyawan</h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="border-bottom p-2">
                                <h6 class="mt-2"><b>A. Credentials</b></h6>
                                <div class="form-group row">
                                    <label for="kode_karyawan" class="col-sm-3 col-form-label ">
                                        Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="Username" value="{{ $karyawan->user->username }}" disabled>
                                    </div>
                                </div>

                                <h6 class="mt-2"><b>B. Employee Information</b></h6>
                                <div class="form-group row">
                                    <label for="status_karyawan_id" class="col-sm-3 col-form-label ">Status
                                    </label>
                                    <div class="col-sm-3">
                                        <select class="form-control form-select" disabled>
                                            <option value="">
                                            </option>
                                            @foreach ($dataStatusKaryawan as $status)
                                                <option value="{{ $status->id }}"
                                                    {{ $status->id == $karyawan->status_karyawan_id ? 'selected' : '' }}>
                                                    {{ $status->status_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="permanent_date" class="col-sm-3 col-form-label "> Permanent
                                        Date</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" value="{{ $karyawan->permanent_date }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="unit_karyawan_id" class="col-sm-3 col-form-label ">Unit
                                    </label>
                                    <div class="col-sm-3">
                                        <select class="form-control form-select" disabled>
                                            <option value="">
                                            </option>
                                            @foreach ($dataUnitKaryawan as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ $unit->id == $karyawan->unit_karyawan_id ? 'selected' : '' }}>
                                                    {{ $unit->unit_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="position_karyawan_id" class="col-sm-3 col-form-label ">Position
                                    </label>
                                    <div class="col-sm-3">
                                        <select class="form-control form-select" disabled>
                                            <option value="">

                                            </option>
                                            @foreach ($dataPositionKaryawan as $position)
                                                <option value="{{ $position->id }}"
                                                    {{ $position->id == $karyawan->position_karyawan_id ? 'selected' : '' }}>
                                                    {{ $position->position_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="join_date" class="col-sm-3 col-form-label ">
                                        Join Date</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" value="{{ $karyawan->join_date }}"
                                            disabled>
                                    </div>
                                </div>
                                <h6 class="mt-2"><b>C. Personal Information</b></h6>
                                <div class="form-group row">
                                    <label for="kode_karyawan" class="col-sm-3 col-form-label ">
                                        Employee Code</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" placeholder="Employee Code"
                                            value="{{ $karyawan->kode_karyawan }}" disabled>
                                    </div>
                                    <label for="nama" class="col-sm-3 col-form-label ">
                                        Employee Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" placeholder="Employee Name"
                                            value="{{ $karyawan->nama_lengkap }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nik" class="col-sm-3 col-form-label ">
                                        Identity Card</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" placeholder="Identity Card"
                                            value="{{ $karyawan->nik }}" disabled>
                                    </div>
                                    <label for="nomor_akun" class="col-sm-3 col-form-label ">
                                        Account No.</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" placeholder="Account No."
                                            value="{{ $karyawan->nomor_akun }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nomor_fingerprint" class="col-sm-3 col-form-label ">
                                        Fingerprint No.</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control" placeholder="Fingerprint No."
                                            value="{{ $karyawan->nomor_fingerprint }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nomor_taxpayer" class="col-sm-3 col-form-label ">
                                        Taxpayer No.</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" placeholder="Taxpayer No."
                                            value="{{ $karyawan->nomor_taxpayer }}" disabled>
                                    </div>
                                    <label for="nama_taxpayer" class="col-sm-3 col-form-label ">
                                        Name of Taxpayer</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" placeholder="Name of Taxpayer"
                                            value="{{ $karyawan->nama_taxpayer }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nomor_bpjs_ketenagakerjaan" class="col-sm-3 col-form-label ">
                                        No BPJS Ketenagakerjaan</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" placeholder="No BPJS Ketenagakerjaan"
                                            value="{{ $karyawan->nomor_bpjs_ketenagakerjaan }}" disabled>
                                    </div>
                                    <label for="iuran_bpjs_ketenagakerjaan" class="col-sm-3 col-form-label ">
                                        Iuran BPJS Ketenagakerjaan</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control"
                                            placeholder="Iuran BPJS Ketenagakerjaan"
                                            value="{{ $karyawan->iuran_bpjs_ketenagakerjaan }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nomor_bpjs_yayasan" class="col-sm-3 col-form-label ">
                                        No BPJS Kesehatan (Yayasan)</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control"
                                            placeholder="No BPJS Kesehatan (Yayasan)"
                                            value="{{ $karyawan->nomor_bpjs_yayasan }}" disabled>
                                    </div>
                                    <label for="nomor_bpjs_pribadi" class="col-sm-3 col-form-label ">
                                        No BPJS Kesehatan (Pribadi)</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control"
                                            placeholder="No BPJS Kesehatan (Pribadi)"
                                            value="{{ $karyawan->nomor_bpjs_pribadi }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jenis_kelamin" class="col-sm-3 col-form-label disabled">Gender</label>
                                    <div class="col-sm-3 pt-1">
                                        <label class="form-check-label me-3"><input type="radio" value="MALE"
                                                @if ($karyawan->jenis_kelamin == 'MALE') checked @endif disabled>
                                            Male</label>
                                        <label class="form-check-label me-3"><input type="radio" value="FEMALE"
                                                @if ($karyawan->jenis_kelamin == 'FEMALE') checked @endif disabled>
                                            Female</label>
                                    </div>
                                    <label for="agama" class="col-sm-3 col-form-label disabled">Religion</label>
                                    <div class="col-sm-3">
                                        <select class="form-control form-select" name="agama" disabled>
                                            <option value=""></option>
                                            <option value="1" @if ($karyawan->agama == '1') selected @endif>Islam
                                            </option>
                                            <option value="2" @if ($karyawan->agama == '2') selected @endif>
                                                Protestan
                                            </option>
                                            <option value="3" @if ($karyawan->agama == '3') selected @endif>
                                                Katolik</option>
                                            <option value="4" @if ($karyawan->agama == '4') selected @endif>Hindu
                                            </option>
                                            <option value="5" @if ($karyawan->agama == '5') selected @endif>Budha
                                            </option>
                                            <option value="6" @if ($karyawan->agama == '6') selected @endif>
                                                Khonghucu
                                            </option>
                                            <option value="7" @if ($karyawan->agama == '7') selected @endif>
                                                Lainnya
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tempat_lahir" class="col-sm-3 col-form-label disabled">Tempat
                                        Lahir</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" placeholder="Tempat Lahir"
                                            value="{{ $karyawan->tempat_lahir }}" disabled>
                                    </div>
                                    <label for="tanggal_lahir" class="col-sm-3 col-form-label disabled">Tanggal
                                        Lahir</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control"
                                            value="{{ $karyawan->tanggal_lahir }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-3 col-form-label disabled">Address</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" placeholder="Address" disabled>{{ $karyawan->alamat }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="alamat_sekarang" class="col-sm-3 col-form-label disabled">
                                        Current
                                        Address</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" placeholder="Current Address " disabled>{{ $karyawan->alamat_sekarang }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kota" class="col-sm-3 col-form-label">City</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="kota" name="kota"
                                            placeholder="City" value="{{ $karyawan->kota }}" disabled>
                                    </div>
                                    <label for="kode_pos" class="col-sm-3 col-form-label ">Pos Code</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                                            value="{{ $karyawan->kode_pos }}" placeholder="Pos Code" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nomor_phone" class="col-sm-3 col-form-label">Phone</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="nomor_phone" name="nomor_phone"
                                            placeholder="Phone" value="{{ $karyawan->nomor_phone }}" disabled>
                                    </div>
                                    <label for="nomor_hp" class="col-sm-3 col-form-label ">Handphone</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="nomor_hp" name="nomor_hp"
                                            value="{{ $karyawan->nomor_hp }}" placeholder="Handphone" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="Email" value="{{ $karyawan->email }}" disabled>
                                    </div>
                                    <label for="email_sekolah" class="col-sm-3 col-form-label ">Email
                                        School</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="email_sekolah"
                                            name="email_sekolah" value="{{ $karyawan->email_sekolah }}"
                                            placeholder="Email School" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="warga_negara" class="col-sm-3 col-form-label">Marital
                                        Status</label>
                                    <div class="col-sm-3">
                                        <select class="form-control form-select" name="status_pernikahan"
                                            id="status_pernikahan" disabled>
                                            <option value=""></option>
                                            <option value="1" @if ($karyawan->status_pernikahan == 1) selected @endif>
                                                Single
                                            </option>
                                            <option value="2" @if ($karyawan->status_pernikahan == 2) selected @endif>
                                                Merried
                                            </option>
                                            <option value="3" @if ($karyawan->status_pernikahan == 3) selected @endif>
                                                Widow
                                            </option>
                                            <option value="3" @if ($karyawan->status_pernikahan == 3) selected @endif>
                                                Widower
                                            </option>
                                        </select>
                                    </div>
                                    <label for="nama_pasangan" class="col-sm-3 col-form-label">Spouse</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="nama_pasangan"
                                            name="nama_pasangan" placeholder="Spouse"
                                            value="{{ $karyawan->nama_pasangan }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jumlah_anak" class="col-sm-3 col-form-label">Number of
                                        Chilldren</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="jumlah_anak" name="jumlah_anak"
                                            placeholder="Number of Chilldren" value="{{ $karyawan->jumlah_anak }}"
                                            disabled>
                                    </div>
                                    <label for="warga_negara" class="col-sm-3 col-form-label">Citizen</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="warga_negara" name="warga_negara"
                                            placeholder="Citizen" value="{{ $karyawan->warga_negara }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="keterangan" class="col-sm-3 col-form-label">Note</label>
                                    <div class="col-sm-9">
                                        <textarea name="keterangan" class="form-control" id="keterangan" placeholder="Note" disabled>{{ $karyawan->keterangan }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="photo_kartu_identitas_show" class="col-sm-3 col-form-label disabled">Photo
                                        Identity Card</label>
                                    <div class="col-sm-3">
                                        @if ($karyawan->photo_kartu_identitas == null)
                                            <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                                id="photo_kartu_identitas_preview_show" width="190px" height="144px">
                                        @else
                                            <img class="mb-2"
                                                src="{{ asset('storage/' . $karyawan->photo_kartu_identitas) }}"
                                                alt="{{ $karyawan->photo_kartu_identitas }}"
                                                alt="photo_kartu_identitas_show" width="190px" height="144px">
                                        @endif
                                    </div>
                                    <label for="photo_taxpayer_show" class="col-sm-3 col-form-label disabled">Photo
                                        Taxpayer</label>
                                    <div class="col-sm-3">
                                        @if ($karyawan->photo_taxpayer == null)
                                            <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                                id="photo_taxpayer_preview_show" width="190px" height="144px">
                                        @else
                                            <img class="mb-2" src="{{ asset('storage/' . $karyawan->photo_taxpayer) }}"
                                                alt="{{ $karyawan->photo_taxpayer }}" alt="photo_taxpayer_show"
                                                width="190px" height="144px">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="photo_kk_show" class="col-sm-3 col-form-label disabled">Photo
                                        Family Card</label>
                                    <div class="col-sm-3">
                                        @if ($karyawan->photo_kk == null)
                                            <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                                id="photo_kk_preview_show" width="190px" height="144px">
                                        @else
                                            <img class="mb-2" src="{{ asset('storage/' . $karyawan->photo_kk) }}"
                                                alt="{{ $karyawan->photo_kk }}" alt="photo_kk_show" width="190px"
                                                height="144px">
                                        @endif
                                    </div>

                                    <label for="other_document_show" class="col-sm-3 col-form-label disabled">
                                        Other Document</label>
                                    <div class="col-sm-3">
                                        @if ($karyawan->other_document == null)
                                            <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                                id="other_document_preview_show" width="190px" height="144px">
                                        @else
                                            <img class="mb-2" src="{{ asset('storage/' . $karyawan->other_document) }}"
                                                alt="{{ $karyawan->other_document }}" alt="other_document_show"
                                                width="190px" height="144px">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modal-edit{{ $karyawan->id }}">Edit</button>
                        </div>

                        <!-- Modal edit  -->
                        <div class="modal fade" id="modal-edit{{ $karyawan->id }}">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit {{ $title }}</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                        </button>
                                    </div>
                                    <form action="{{ route('profileguru.update', $karyawan->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        {{ method_field('PATCH') }}
                                        @csrf
                                        <div class="modal-body">
                                            <h6 class="mt-2"><b>A. Credentials</b></h6>
                                            <div class="form-group row">
                                                <label for="username" class="col-sm-3 col-form-label ">
                                                    Username</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" placeholder="Username"
                                                        value="{{ $karyawan->user->username }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="old_password" class="col-sm-3 col-form-label ">
                                                    Old Password</label>
                                                <div class="col-sm-3">
                                                    <input type="password" class="form-control" id="old_password"
                                                        name="old_password" placeholder="Old password" value="">
                                                </div>
                                                <label for="kode_karyawan" class="col-sm-3 col-form-label ">
                                                    Old Password</label>
                                                <div class="col-sm-3">
                                                    <input type="password" class="form-control" id="new_password"
                                                        name="new_password" placeholder="New password" value="">
                                                </div>
                                            </div>

                                            <h6 class="mt-2"><b>B. Employee Information</b></h6>
                                            <div class="form-group row">
                                                <label for="status_karyawan_id" class="col-sm-3 col-form-label ">Status
                                                </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control form-select" id="status_karyawan_id"
                                                        name="status_karyawan_id" disabled>
                                                        <option value="">-- Select Status --
                                                        </option>
                                                        @foreach ($dataStatusKaryawan as $status)
                                                            <option value="{{ $status->id }}"
                                                                {{ $karyawan->position_karyawan_id == $status->id ? 'selected' : '' }}>
                                                                {{ $status->status_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label for="permanent_date" class="col-sm-3 col-form-label "> Permanent
                                                    Date</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" id="permanent_date"
                                                        name="permanent_date" value="{{ $karyawan->permanent_date }}"
                                                        disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="unit_karyawan_id" class="col-sm-3 col-form-label ">Unit
                                                </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control form-select" id="unit_karyawan_id"
                                                        name="unit_karyawan_id" disabled>
                                                        <option value="">-- Select Unit --
                                                        </option>
                                                        @foreach ($dataUnitKaryawan as $unit)
                                                            <option value="{{ $unit->id }}"
                                                                {{ $karyawan->position_karyawan_id == $unit->id ? 'selected' : '' }}>
                                                                {{ $unit->unit_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label for="position_karyawan_id"
                                                    class="col-sm-3 col-form-label ">Position
                                                </label>
                                                <div class="col-sm-3">
                                                    <select class="form-control form-select" id="position_karyawan_id"
                                                        name="position_karyawan_id" disabled>
                                                        <option value="">
                                                            -- Select Position --
                                                        </option>
                                                        @foreach ($dataPositionKaryawan as $position)
                                                            <option value="{{ $position->id }}"
                                                                {{ $karyawan->position_karyawan_id == $position->id ? 'selected' : '' }}>
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
                                                        name="join_date" value="{{ $karyawan->join_date }}" disabled>
                                                </div>
                                            </div>
                                            <h6 class="mt-2"><b>C. Personal Information</b></h6>
                                            <div class="form-group row">
                                                <label for="kode_karyawan" class="col-sm-3 col-form-label ">
                                                    Employee Code</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="kode_karyawan"
                                                        name="kode_karyawan" placeholder="Employee Code"
                                                        value="{{ $karyawan->kode_karyawan }}" disabled>
                                                </div>
                                                <label for="nama_lengkap" class="col-sm-3 col-form-label ">
                                                    Employee Name</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nama_lengkap"
                                                        name="nama_lengkap" placeholder="Employee Name"
                                                        value="{{ $karyawan->nama_lengkap }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nik" class="col-sm-3 col-form-label ">
                                                    Identity Card</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nik"
                                                        name="nik" placeholder="Identity Card"
                                                        value="{{ $karyawan->nik }}" required>
                                                </div>
                                                <label for="nomor_akun" class="col-sm-3 col-form-label ">
                                                    Account No.</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nomor_akun"
                                                        name="nomor_akun" placeholder="Account No."
                                                        value="{{ $karyawan->nomor_akun }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nomor_fingerprint" class="col-sm-3 col-form-label ">
                                                    Fingerprint No.</label>
                                                <div class="col-sm-3">
                                                    <input type="number" class="form-control" id="nomor_fingerprint"
                                                        name="nomor_fingerprint" placeholder="Fingerprint No."
                                                        value="{{ $karyawan->nomor_fingerprint }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nomor_taxpayer" class="col-sm-3 col-form-label ">
                                                    Taxpayer No.</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nomor_taxpayer"
                                                        name="nomor_taxpayer" placeholder="Taxpayer No."
                                                        value="{{ $karyawan->nomor_taxpayer }}">
                                                </div>
                                                <label for="nama_taxpayer" class="col-sm-3 col-form-label ">
                                                    Name of Taxpayer</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nama_taxpayer"
                                                        name="nama_taxpayer" placeholder="Name of Taxpayer"
                                                        value="{{ $karyawan->nama_taxpayer }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nomor_bpjs_ketenagakerjaan" class="col-sm-3 col-form-label ">
                                                    No BPJS Ketenagakerjaan</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control"
                                                        id="nomor_bpjs_ketenagakerjaan" name="nomor_bpjs_ketenagakerjaan"
                                                        placeholder="No BPJS Ketenagakerjaan"
                                                        value="{{ $karyawan->nomor_bpjs_ketenagakerjaan }}">
                                                </div>
                                                <label for="iuran_bpjs_ketenagakerjaan" class="col-sm-3 col-form-label ">
                                                    Iuran BPJS Ketenagakerjaan</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control"
                                                        id="iuran_bpjs_ketenagakerjaan" name="iuran_bpjs_ketenagakerjaan"
                                                        placeholder="Iuran BPJS Ketenagakerjaan"
                                                        value="{{ $karyawan->iuran_bpjs_ketenagakerjaan }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nomor_bpjs_yayasan" class="col-sm-3 col-form-label ">
                                                    No BPJS Kesehatan (Yayasan)</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nomor_bpjs_yayasan"
                                                        name="nomor_bpjs_yayasan"
                                                        placeholder="No BPJS Kesehatan (Yayasan)"
                                                        value="{{ $karyawan->nomor_bpjs_yayasan }}">
                                                </div>
                                                <label for="nomor_bpjs_pribadi" class="col-sm-3 col-form-label ">
                                                    No BPJS Kesehatan (Pribadi)</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nomor_bpjs_pribadi"
                                                        name="nomor_bpjs_pribadi"
                                                        placeholder="No BPJS Kesehatan (Pribadi)"
                                                        value="{{ $karyawan->nomor_bpjs_pribadi }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jenis_kelamin" class="col-sm-3 col-form-label">Gender</label>
                                                <div class="col-sm-3 pt-1">
                                                    <label class="form-check-label me-3"><input type="radio"
                                                            value="MALE" name="jenis_kelamin"
                                                            @if ($karyawan->jenis_kelamin == 'MALE') checked @endif>
                                                        Male</label>
                                                    <label class="form-check-label me-3"><input type="radio"
                                                            value="FEMALE" name="jenis_kelamin"
                                                            @if ($karyawan->jenis_kelamin == 'FEMALE') checked @endif>
                                                        Female</label>
                                                </div>
                                                <label for="agama"
                                                    class="col-sm-3 col-form-label required">Religion</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control form-select" name="agama" required>
                                                        <option value="">-- Select Religion --</option>
                                                        <option value="1"
                                                            @if ($karyawan->agama == '1') selected @endif>Islam
                                                        </option>
                                                        <option value="2"
                                                            @if ($karyawan->agama == '2') selected @endif>
                                                            Protestan
                                                        </option>
                                                        <option value="3"
                                                            @if ($karyawan->agama == '3') selected @endif>
                                                            Katolik</option>
                                                        <option value="4"
                                                            @if ($karyawan->agama == '4') selected @endif>Hindu
                                                        </option>
                                                        <option value="5"
                                                            @if ($karyawan->agama == '5') selected @endif>Budha
                                                        </option>
                                                        <option value="6"
                                                            @if ($karyawan->agama == '6') selected @endif>
                                                            Khonghucu
                                                        </option>
                                                        <option value="7"
                                                            @if ($karyawan->agama == '7') selected @endif>
                                                            Lainnya
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tempat_lahir" class="col-sm-3 col-form-label required">Tempat
                                                    Lahir</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="tempat_lahir"
                                                        name="tempat_lahir" placeholder="Tempat Lahir"
                                                        value="{{ $karyawan->tempat_lahir }}">
                                                </div>
                                                <label for="tanggal_lahir"
                                                    class="col-sm-3 col-form-label required">Tanggal
                                                    Lahir</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" id="tanggal_lahir"
                                                        name="tanggal_lahir" value="{{ $karyawan->tanggal_lahir }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="alamat"
                                                    class="col-sm-3 col-form-label required">Address</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Address" required>{{ $karyawan->alamat }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="alamat_sekarang" class="col-sm-3 col-form-label">
                                                    Current
                                                    Address</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="alamat_sekarang" name="alamat_sekarang" placeholder="Current Address ">{{ $karyawan->alamat_sekarang }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kota" class="col-sm-3 col-form-label">City</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="kota"
                                                        name="kota" placeholder="City" value="{{ $karyawan->kota }}">
                                                </div>
                                                <label for="kode_pos" class="col-sm-3 col-form-label ">Pos Code</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="kode_pos"
                                                        name="kode_pos" value="{{ $karyawan->kode_pos }}"
                                                        placeholder="Pos Code" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nomor_hp" class="col-sm-3 col-form-label ">Handphone</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nomor_hp"
                                                        name="nomor_hp" value="{{ $karyawan->nomor_hp }}"
                                                        placeholder="Handphone" required>
                                                </div>
                                                <label for="nomor_phone" class="col-sm-3 col-form-label">Phone</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nomor_phone"
                                                        name="nomor_phone" placeholder="Phone"
                                                        value="{{ $karyawan->nomor_phone }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="email"
                                                        name="email" placeholder="Email"
                                                        value="{{ $karyawan->email }}" required>
                                                </div>
                                                <label for="email_sekolah" class="col-sm-3 col-form-label ">Email
                                                    School</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="email_sekolah"
                                                        name="email_sekolah" value="{{ $karyawan->email_sekolah }}"
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
                                                            @if ($karyawan->status_pernikahan == 1) selected @endif>Single
                                                        </option>
                                                        <option value="2"
                                                            @if ($karyawan->status_pernikahan == 2) selected @endif>Merried
                                                        </option>
                                                        <option value="3"
                                                            @if ($karyawan->status_pernikahan == 3) selected @endif>Widow
                                                        </option>
                                                        <option value="3"
                                                            @if ($karyawan->status_pernikahan == 3) selected @endif>Widower
                                                        </option>
                                                    </select>
                                                </div>
                                                <label for="nama_pasangan" class="col-sm-3 col-form-label">Spouse</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="nama_pasangan"
                                                        name="nama_pasangan" placeholder="Spouse"
                                                        value="{{ $karyawan->nama_pasangan }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jumlah_anak" class="col-sm-3 col-form-label">Number of
                                                    Chilldren</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="jumlah_anak"
                                                        name="jumlah_anak" placeholder="Number of Chilldren"
                                                        value="{{ $karyawan->jumlah_anak }}">
                                                </div>
                                                <label for="warga_negara" class="col-sm-3 col-form-label">Citizen</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="warga_negara"
                                                        name="warga_negara" placeholder="Citizen"
                                                        value="{{ $karyawan->warga_negara }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="keterangan" class="col-sm-3 col-form-label">Note</label>
                                                <div class="col-sm-9">
                                                    <textarea name="keterangan" class="form-control" id="keterangan" placeholder="Note">{{ $karyawan->keterangan }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="pas_photo" class="col-sm-3 col-form-label ">
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
                                                    @if ($karyawan->pas_photo == null)
                                                        <img src="{{ asset('assets/dist/img/3x4.png') }}" alt=""
                                                            id="pas_photo_preview" width="105px" height="144px">
                                                    @else
                                                        <img class="mb-2"
                                                            src="{{ asset('storage/' . $karyawan->pas_photo) }}"
                                                            alt="{{ $karyawan->pas_photo_preview }}"
                                                            id="pas_photo_preview" alt="pas_photo_preview" width="105px"
                                                            height="144px">
                                                    @endif
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
                                                    @if ($karyawan->photo_kartu_identitas == null)
                                                        <img src="{{ asset('assets/dist/img/preview.png') }}"
                                                            alt="" id="photo_kartu_identitas_preview"
                                                            width="190px" height="144px">
                                                    @else
                                                        <img class="mb-2"
                                                            src="{{ asset('storage/' . $karyawan->photo_kartu_identitas) }}"
                                                            alt="{{ $karyawan->photo_kartu_identitas }}"
                                                            id="photo_kartu_identitas_preview" alt="photo_kartu_identitas"
                                                            width="190px" height="144px">
                                                    @endif
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
                                                    @if ($karyawan->photo_taxpayer == null)
                                                        <img src="{{ asset('assets/dist/img/preview.png') }}"
                                                            alt="" id="photo_taxpayer_preview" width="190px"
                                                            height="144px">
                                                    @else
                                                        <img class="mb-2"
                                                            src="{{ asset('storage/' . $karyawan->photo_taxpayer) }}"
                                                            alt="{{ $karyawan->photo_taxpayer }}"
                                                            id="photo_taxpayer_preview" width="190px" height="144px">
                                                    @endif
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
                                                    @if ($karyawan->photo_kk == null)
                                                        <img src="{{ asset('assets/dist/img/preview.png') }}"
                                                            alt="" id="photo_kk_preview" width="190px"
                                                            height="144px">
                                                    @else
                                                        <img class="mb-2"
                                                            src="{{ asset('storage/' . $karyawan->photo_kk) }}"
                                                            alt="{{ $karyawan->photo_kk }}" id="photo_kk_preview"
                                                            width="190px" height="144px">
                                                    @endif
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
                                                    @if ($karyawan->other_document == null)
                                                        <img src="{{ asset('assets/dist/img/preview.png') }}"
                                                            alt="" id="other_document_preview" width="190px"
                                                            height="144px">
                                                    @else
                                                        <img class="mb-2"
                                                            src="{{ asset('storage/' . $karyawan->other_document) }}"
                                                            alt="{{ $karyawan->other_document }}"
                                                            id="other_document_preview" width="190px" height="144px">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-end">
                                                <button type="button" class="btn btn-default"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
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
        </div>
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

<!-- Modal edit  -->
<div class="modal fade" id="modal-edit{{ $karyawan->id }}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit {{ $title }}</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </button>
            </div>
            <form action="{{ route('tu.profile.update', $karyawan->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                @csrf
                <div class="modal-body">
                    <div class="border-bottom p-2">
                        <h6 class="mt-2"><b>Authentication User</b></h6>
                        {{-- username --}}
                        <div class="form-group row">
                            <label for="username" class="col-sm-3 col-form-label ">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" placeholder="Username"
                                    value="{{ $karyawan->user->username }}" required>
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_lama" class="col-sm-3 col-form-label">Password
                                Lama</label>
                            <div class="col-sm-3">
                                <input type="password" class="form-control @error('password_lama') is-invalid @enderror"
                                    id="password_lama" name="password_lama" placeholder="Password Lama" value="">
                                @error('password_lama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="password_baru" class="col-sm-2 col-form-label ">Password
                                Baru</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control @error('password_baru') is-invalid @enderror"
                                    id="password_baru" name="password_baru" placeholder="Password Baru" value="">
                                @error('password_baru')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @if ($user->hasRole(['Admin', 'Curriculum']))
                            <div class="form-group row">
                                <label for="role" class="col-sm-3 col-form-label">Role</label>
                                <div class="col-sm-9">
                                    <select class="form-control form-select select2 @error('role') is-invalid @enderror"
                                        name="role[]" id="role" multiple="multiple">
                                        <option value="">=== Select Role ===</option>
                                        @foreach ($dataRoles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $karyawan->user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status" class="col-sm-3 col-form-label">Status
                                    Akun</label>
                                <div class="col-sm-9 pt-1">
                                    <label class="radio-inline me-3"><input type="radio" name="status" value="1"
                                            @if ($karyawan->user->status == 1) checked @endif required>
                                        Aktif</label>
                                    <label class="radio-inline me-3"><input type="radio" name="status" value="0"
                                            @if ($karyawan->user->status == 0) checked @endif required>
                                        Non Aktif</label>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="role[]" value="{{ $karyawan->user->getRoleId() }}">
                            <input type="hidden" name="status" value="{{ $karyawan->user->status }}">
                        @endif
                    </div>

                    <div class="border-bottom p-2">
                        @if ($user->hasRole(['Admin', 'Curriculum']))

                            <h6 class="mt-2"><b>A. Employee Information</b></h6>
                            <div class="form-group row">
                                <label for="status_karyawan_id" class="col-sm-3 col-form-label ">Status
                                </label>
                                <div class="col-sm-3">
                                    <select
                                        class="form-control form-select select2 @error('status_karyawan_id') is-invalid @enderror"
                                        id="status_karyawan_id" name="status_karyawan_id" required>
                                        <option value="">-- Select Status --
                                        </option>
                                        @foreach ($dataStatusKaryawan as $status)
                                            <option value="{{ $status->id }}"
                                                {{ $karyawan->status_karyawan_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->status_nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_karyawan_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label for="permanent_date" class="col-sm-3 col-form-label ">
                                    Permanent
                                    Date</label>
                                <div class="col-sm-3">
                                    <input type="date"
                                        class="form-control @error('permanent_date') is-invalid @enderror"
                                        id="permanent_date" name="permanent_date"
                                        value="{{ $karyawan->permanent_date }}">
                                    @error('permanent_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="unit_karyawan_id" class="col-sm-3 col-form-label ">Unit
                                </label>
                                <div class="col-sm-3">
                                    <select
                                        class="form-control form-select select2 @error('unit_karyawan_id') is-invalid @enderror"
                                        id="unit_karyawan_id" name="unit_karyawan_id" required>
                                        <option value="">-- Select Unit --
                                        </option>
                                        @foreach ($dataUnitKaryawan as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ $unit->id == $karyawan->unit_karyawan_id ? 'selected' : '' }}>
                                                {{ $unit->unit_nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_karyawan_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label for="position_karyawan_id" class="col-sm-3 col-form-label ">Position
                                </label>
                                <div class="col-sm-3">
                                    <select
                                        class="form-control form-select select2 @error('position_karyawan_id') is-invalid @enderror"
                                        id="position_karyawan_id" name="position_karyawan_id" required>
                                        <option value="">
                                            -- Select Position --
                                        </option>
                                        @foreach ($dataPositionKaryawan as $position)
                                            <option value="{{ $position->id }}"
                                                {{ $karyawan->position_karyawan_id == $position->id ? 'selected' : '' }}>
                                                {{ $position->position_nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('position_karyawan_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="join_date" class="col-sm-3 col-form-label ">
                                    Join Date</label>
                                <div class="col-sm-3">
                                    <input type="date"
                                        class="form-control @error('join_date') is-invalid @enderror" id="join_date"
                                        name="join_date" value="{{ $karyawan->join_date }}" required>
                                    @error('join_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label for="resign_date" class="col-sm-3 col-form-label ">
                                    Resign Date</label>
                                <div class="col-sm-3">
                                    <input type="date"
                                        class="form-control @error('resign_date') is-invalid @enderror"
                                        id="resign_date" name="resign_date" value="{{ $karyawan->resign_date }}">
                                    @error('resign_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="status_karyawan_id"
                                value="{{ $karyawan->status_karyawan_id }}">
                            <input type="hidden" name="permanent_date" value="{{ $karyawan->permanent_date }}">
                            <input type="hidden" name="unit_karyawan_id" value="{{ $karyawan->unit_karyawan_id }}">
                            <input type="hidden" name="position_karyawan_id"
                                value="{{ $karyawan->position_karyawan_id }}">
                            <input type="hidden" name="join_date" value="{{ $karyawan->join_date }}">
                            <input type="hidden" name="resign_date" value="{{ $karyawan->resign_date }}">
                        @endif
                        <h6 class="mt-2"><b>B. Personal Information</b></h6>
                        <div class="form-group row">
                            <label for="kode_karyawan" class="col-sm-3 col-form-label ">
                                Employee Code</label>
                            <div class="col-sm-3">
                                <input type="text"
                                    class="form-control @error('kode_karyawan') is-invalid @enderror"
                                    id="kode_karyawan" name="kode_karyawan" placeholder="Employee Code"
                                    value="{{ $karyawan->kode_karyawan }}" required>
                                @error('kode_karyawan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="nama_lengkap" class="col-sm-3 col-form-label ">
                                Employee Name</label>
                            <div class="col-sm-3">
                                <input type="text"
                                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    id="nama_lengkap" name="nama_lengkap" placeholder="Employee Name"
                                    value="{{ $karyawan->nama_lengkap }}" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nik" class="col-sm-3 col-form-label ">
                                Identity Card</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                    id="nik" name="nik" placeholder="Identity Card"
                                    value="{{ $karyawan->nik }}" required>
                                @error('nik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="nomor_akun" class="col-sm-3 col-form-label ">
                                Account No.</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control @error('nomor_akun') is-invalid @enderror"
                                    id="nomor_akun" name="nomor_akun" placeholder="Account No."
                                    value="{{ $karyawan->nomor_akun }}">
                                @error('nomor_akun')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nomor_fingerprint" class="col-sm-3 col-form-label ">
                                Fingerprint No.</label>
                            <div class="col-sm-3">
                                <input type="number"
                                    class="form-control @error('nomor_fingerprint') is-invalid @enderror"
                                    id="nomor_fingerprint" name="nomor_fingerprint" placeholder="Fingerprint No."
                                    value="{{ $karyawan->nomor_fingerprint }}">
                                @error('nomor_fingerprint')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nomor_taxpayer" class="col-sm-3 col-form-label ">
                                Taxpayer No.</label>
                            <div class="col-sm-3">
                                <input type="text"
                                    class="form-control @error('nomor_taxpayer') is-invalid @enderror"
                                    id="nomor_taxpayer" name="nomor_taxpayer" placeholder="Taxpayer No."
                                    value="{{ $karyawan->nomor_taxpayer }}">
                                @error('nomor_taxpayer')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="nama_taxpayer" class="col-sm-3 col-form-label ">
                                Name of Taxpayer</label>
                            <div class="col-sm-3">
                                <input type="text"
                                    class="form-control @error('nama_taxpayer') is-invalid @enderror"
                                    id="nama_taxpayer" name="nama_taxpayer" placeholder="Name of Taxpayer"
                                    value="{{ $karyawan->nama_taxpayer }}">
                                @error('nama_taxpayer')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nomor_bpjs_ketenagakerjaan" class="col-sm-3 col-form-label ">
                                No BPJS Ketenagakerjaan</label>
                            <div class="col-sm-3">
                                <input type="text"
                                    class="form-control @error('nomor_bpjs_ketenagakerjaan') is-invalid @enderror"
                                    id="nomor_bpjs_ketenagakerjaan" name="nomor_bpjs_ketenagakerjaan"
                                    placeholder="No BPJS Ketenagakerjaan"
                                    value="{{ $karyawan->nomor_bpjs_ketenagakerjaan }}">
                                @error('nomor_bpjs_ketenagakerjaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="iuran_bpjs_ketenagakerjaan" class="col-sm-3 col-form-label ">
                                Iuran BPJS Ketenagakerjaan</label>
                            <div class="col-sm-3">
                                <input type="text"
                                    class="form-control @error('iuran_bpjs_ketenagakerjaan') is-invalid @enderror"
                                    id="iuran_bpjs_ketenagakerjaan" name="iuran_bpjs_ketenagakerjaan"
                                    placeholder="Iuran BPJS Ketenagakerjaan"
                                    value="{{ $karyawan->iuran_bpjs_ketenagakerjaan }}">
                                @error('iuran_bpjs_ketenagakerjaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nomor_bpjs_yayasan" class="col-sm-3 col-form-label ">
                                No BPJS Kesehatan (Yayasan)</label>
                            <div class="col-sm-3">
                                <input type="text"
                                    class="form-control @error('nomor_bpjs_yayasan') is-invalid @enderror"
                                    id="nomor_bpjs_yayasan" name="nomor_bpjs_yayasan"
                                    placeholder="No BPJS Kesehatan (Yayasan)"
                                    value="{{ $karyawan->nomor_bpjs_yayasan }}">
                                @error('nomor_bpjs_yayasan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="nomor_bpjs_pribadi" class="col-sm-3 col-form-label ">
                                No BPJS Kesehatan (Pribadi)</label>
                            <div class="col-sm-3">
                                <input type="text"
                                    class="form-control @error('nomor_bpjs_pribadi') is-invalid @enderror"
                                    id="nomor_bpjs_pribadi" name="nomor_bpjs_pribadi"
                                    placeholder="No BPJS Kesehatan (Pribadi)"
                                    value="{{ $karyawan->nomor_bpjs_pribadi }}">
                                @error('nomor_bpjs_pribadi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jenis_kelamin" class="col-sm-3 col-form-label">Gender</label>
                            <div class="col-sm-3 pt-1">
                                <label class="form-check-label me-3"><input type="radio" value="MALE"
                                        name="jenis_kelamin" @if ($karyawan->jenis_kelamin == 'MALE') checked @endif>
                                    Male</label>
                                <label class="form-check-label me-3"><input type="radio" value="FEMALE"
                                        name="jenis_kelamin" @if ($karyawan->jenis_kelamin == 'FEMALE') checked @endif>
                                    Female</label>
                            </div>
                            <label for="agama" class="col-sm-3 col-form-label required">Religion</label>
                            <div class="col-sm-3">
                                <select class="form-control form-select select2 @error('agama') is-invalid @enderror"
                                    name="agama" required>
                                    <option value="">-- Select Religion --</option>
                                    <option value="1" @if ($karyawan->agama == '1') selected @endif>
                                        Islam
                                    </option>
                                    <option value="2" @if ($karyawan->agama == '2') selected @endif>
                                        Protestan
                                    </option>
                                    <option value="3" @if ($karyawan->agama == '3') selected @endif>
                                        Katolik</option>
                                    <option value="4" @if ($karyawan->agama == '4') selected @endif>
                                        Hindu
                                    </option>
                                    <option value="5" @if ($karyawan->agama == '5') selected @endif>
                                        Budha
                                    </option>
                                    <option value="6" @if ($karyawan->agama == '6') selected @endif>
                                        Khonghucu
                                    </option>
                                    <option value="7" @if ($karyawan->agama == '7') selected @endif>
                                        Lainnya
                                    </option>
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tempat_lahir" class="col-sm-3 col-form-label required">Tempat
                                Lahir</label>
                            <div class="col-sm-3">
                                <input type="text"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir"
                                    value="{{ $karyawan->tempat_lahir }}" required>
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="tanggal_lahir" class="col-sm-3 col-form-label required">Tanggal
                                Lahir</label>
                            <div class="col-sm-3">
                                <input type="date"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    id="tanggal_lahir" name="tanggal_lahir" value="{{ $karyawan->tanggal_lahir }}"
                                    required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-3 col-form-label required">Address</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                                    placeholder="Address" required>{{ $karyawan->alamat }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat_sekarang" class="col-sm-3 col-form-label">
                                Current
                                Address</label>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('alamat_sekarang') is-invalid @enderror" id="alamat_sekarang"
                                    name="alamat_sekarang" placeholder="Current Address ">{{ $karyawan->alamat_sekarang }}</textarea>
                                @error('alamat_sekarang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kota" class="col-sm-3 col-form-label">City</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control @error('kota') is-invalid @enderror"
                                    id="kota" name="kota" placeholder="City" value="{{ $karyawan->kota }}">
                                @error('kota')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="kode_pos" class="col-sm-3 col-form-label ">Pos
                                Code</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control @error('kode_pos') is-invalid @enderror"
                                    id="kode_pos" name="kode_pos" value="{{ $karyawan->kode_pos }}"
                                    placeholder="Pos Code" required>
                                @error('kode_pos')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nomor_hp" class="col-sm-3 col-form-label ">Handphone</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror"
                                    id="nomor_hp" name="nomor_hp" value="{{ $karyawan->nomor_hp }}"
                                    placeholder="Handphone" required>
                                @error('nomor_hp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="nomor_phone" class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control @error('nomor_phone') is-invalid @enderror"
                                    id="nomor_phone" name="nomor_phone" placeholder="Phone"
                                    value="{{ $karyawan->nomor_phone }}">
                                @error('nomor_phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Email"
                                    value="{{ $karyawan->email }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="email_sekolah" class="col-sm-3 col-form-label ">Email
                                School</label>
                            <div class="col-sm-3">
                                <input type="text"
                                    class="form-control @error('email_sekolah') is-invalid @enderror"
                                    id="email_sekolah" name="email_sekolah" value="{{ $karyawan->email_sekolah }}"
                                    placeholder="Email School">
                                @error('email_sekolah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status_pernikahan" class="col-sm-3 col-form-label">Marital
                                Status</label>
                            <div class="col-sm-3">
                                <select
                                    class="form-control form-select select2 @error('status_pernikahan') is-invalid @enderror"
                                    name="status_pernikahan" id="status_pernikahan">
                                    <option value="">-- Select Marital Status --
                                    </option>
                                    <option value="2" @if ($karyawan->status_pernikahan == 1) selected @endif>
                                        Merried
                                    </option>
                                    <option value="1" @if ($karyawan->status_pernikahan == 2) selected @endif>
                                        Single
                                    </option>
                                    <option value="3" @if ($karyawan->status_pernikahan == 3) selected @endif>
                                        Widow
                                    </option>
                                    <option value="3" @if ($karyawan->status_pernikahan == 4) selected @endif>
                                        Widower
                                    </option>
                                </select>
                                @error('status_pernikahan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="nama_pasangan" class="col-sm-3 col-form-label">Spouse</label>
                            <div class="col-sm-3">
                                <input type="text"
                                    class="form-control @error('nama_pasangan') is-invalid @enderror"
                                    id="nama_pasangan" name="nama_pasangan" placeholder="Spouse"
                                    value="{{ $karyawan->nama_pasangan }}">
                                @error('nama_pasangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlah_anak" class="col-sm-3 col-form-label">Number of
                                Chilldren</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control @error('jumlah_anak') is-invalid @enderror"
                                    id="jumlah_anak" name="jumlah_anak" placeholder="Number of Chilldren"
                                    value="{{ $karyawan->jumlah_anak }}">
                                @error('jumlah_anak')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <label for="warga_negara" class="col-sm-3 col-form-label">Citizen</label>
                            <div class="col-sm-3">
                                <input type="text"
                                    class="form-control @error('warga_negara') is-invalid @enderror"
                                    id="warga_negara" name="warga_negara" placeholder="Citizen"
                                    value="{{ $karyawan->warga_negara }}">
                                @error('warga_negara')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan" class="col-sm-3 col-form-label">Note</label>
                            <div class="col-sm-9">
                                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                    placeholder="Note">{{ $karyawan->keterangan }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ttd" class="col-sm-3 col-form-label ">
                                Signature</label>
                            <div class="col-sm-6 custom-file">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="ttd"
                                            class="custom-file-input form-control form-control @error('ttd') is-invalid @enderror"
                                            id="ttd" onchange="readURLTtd(this);">
                                        @error('ttd')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                @if (Storage::disk('public')->exists('ttd/' . $karyawan->kode_karyawan . '.jpg'))
                                    <img class="mb-2"
                                        src="{{ asset('storage/ttd/' . $karyawan->kode_karyawan . '.jpg') }}"
                                        alt="{{ $karyawan->ttd }}" alt="ttd" id="ttd_preview" width="190px">
                                @else
                                    <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                        id="ttd_preview" width="190px" height="144px">
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pas_photo" class="col-sm-3 col-form-label ">
                                Photo</label>
                            <div class="col-sm-6 custom-file">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="pas_photo"
                                            class="custom-file-input form-control form-control @error('pas_photo') is-invalid @enderror"
                                            id="pas_photo" onchange="readURLPasPhoto(this);">
                                        @error('pas_photo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                @if (Storage::disk('public')->exists('karyawan/' . $karyawan->kode_karyawan . '.jpg'))
                                    <img class="mb-2"
                                        src="{{ asset('storage/karyawan/' . $karyawan->kode_karyawan . '.jpg') }}"
                                        alt="{{ $karyawan->pas_photo }}" alt="pas_photo" id="pas_photo_preview"
                                        width="105px">
                                @else
                                    <img src="{{ asset('assets/dist/img/3x4.png') }}" alt=""
                                        id="pas_photo_preview" width="105px" height="144px">
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
                                            class="custom-file-input form-control form-control @error('photo_kartu_identitas') is-invalid @enderror"
                                            id="photo_kartu_identitas" onchange="readURLKartuIdentitas(this);">
                                        @error('photo_kartu_identitas')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                @if ($karyawan->photo_kartu_identitas == null)
                                    <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                        id="photo_kartu_identitas_preview" width="190px" height="144px">
                                @else
                                    <img class="mb-2"
                                        src="{{ asset('storage/' . $karyawan->photo_kartu_identitas) }}"
                                        alt="{{ $karyawan->photo_kartu_identitas }}"
                                        id="photo_kartu_identitas_preview" alt="photo_kartu_identitas" width="190px"
                                        height="144px">
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
                                            class="custom-file-input form-control form-control @error('photo_taxpayer') is-invalid @enderror"
                                            id="photo_taxpayer" onchange="readURLTaxpayer(this);">
                                        @error('photo_taxpayer')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                @if ($karyawan->photo_taxpayer == null)
                                    <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                        id="photo_taxpayer_preview" width="190px" height="144px">
                                @else
                                    <img class="mb-2" src="{{ asset('storage/' . $karyawan->photo_taxpayer) }}"
                                        alt="{{ $karyawan->photo_taxpayer }}" id="photo_taxpayer_preview"
                                        width="190px" height="144px">
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
                                            class="custom-file-input form-control form-control @error('photo_kk') is-invalid @enderror"
                                            id="photo_kk" onchange="readURLKK(this);">
                                        @error('photo_kk')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                @if ($karyawan->photo_kk == null)
                                    <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                        id="photo_kk_preview" width="190px" height="144px">
                                @else
                                    <img class="mb-2" src="{{ asset('storage/' . $karyawan->photo_kk) }}"
                                        alt="{{ $karyawan->photo_kk }}" id="photo_kk_preview" width="190px"
                                        height="144px">
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
                                            class="custom-file-input form-control form-control @error('other_document') is-invalid @enderror"
                                            id="other_document" onchange="readURLOtherDocument(this);">
                                        @error('other_document')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                @if ($karyawan->other_document == null)
                                    <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                        id="other_document_preview" width="190px" height="144px">
                                @else
                                    <img class="mb-2" src="{{ asset('storage/' . $karyawan->other_document) }}"
                                        alt="{{ $karyawan->other_document }}" id="other_document_preview"
                                        width="190px" height="144px">
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <!-- /.card -->
</div>

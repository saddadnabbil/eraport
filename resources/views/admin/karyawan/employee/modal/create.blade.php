<!-- Modal tambah  -->
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah {{ $title }}</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </button>
            </div>
            <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h6 class="mt-2"><b>A. User Information</b></h6>
                    <div class="form-group row">
                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" placeholder="username" value="{{ old('username') }}"
                                required>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="password" value="{{ old('password') }}"
                                required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select class="form-control form-select select2 @error('username') is-invalid @enderror"
                                name="role[]" id="" multiple="multiple" required>
                                <option value="" selected>-- Select Role --</option>
                                @foreach ($dataRoles as $role)
                                    <option value="{{ $role->id }}"
                                        @if (old('role') == $role->id) selected @endif>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <h6 class="mt-4"><b>A. Employee Information</b></h6>
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
                                        {{ old('status_karyawan_id') == $status->id ? 'selected' : '' }}>
                                        {{ $status->status_nama }}</option>
                                @endforeach
                            </select>
                            @error('status_karyawan_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <label for="permanent_date" class="col-sm-3 col-form-label "> Permanent
                            Date</label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control @error('permanent_date') is-invalid @enderror"
                                id="permanent_date" name="permanent_date" value="{{ old('permanent_date') }}">
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
                                        {{ old('unit_karyawan_id') == $unit->id ? 'selected' : '' }}>
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
                                        {{ old('position_karyawan_id') == $position->id ? 'selected' : '' }}>
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
                            <input type="date" class="form-control @error('join_date') is-invalid @enderror"
                                id="join_date" name="join_date" value="{{ old('join_date') }}" required>
                            @error('join_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <label for="resign_date" class="col-sm-3 col-form-label ">
                            Resign Date</label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control @error('resign_date') is-invalid @enderror"
                                id="resign_date" name="resign_date" value="{{ old('resign_date') }}">
                            @error('resign_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <h6 class="mt-4"><b>B. Personal Information</b></h6>
                    <div class="form-group row">
                        <label for="kode_karyawan" class="col-sm-3 col-form-label ">
                            Employee Code</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('kode_karyawan') is-invalid @enderror"
                                id="kode_karyawan" name="kode_karyawan" placeholder="Employee Code"
                                value="{{ old('kode_karyawan') }}" required>
                            @error('kode_karyawan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <label for="nama_lengkap" class="col-sm-3 col-form-label ">
                            Employee Name</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                id="nama_lengkap" name="nama_lengkap" placeholder="Employee Name"
                                value="{{ old('nama_lengkap') }}" required>
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
                                value="{{ old('nik') }}" minlength="16" maxlength="16" required>
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
                                value="{{ old('nomor_akun') }}">
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
                                value="{{ old('nomor_fingerprint') }}">
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
                            <input type="text" class="form-control @error('nomor_taxpayer') is-invalid @enderror"
                                id="nomor_taxpayer" name="nomor_taxpayer" placeholder="Taxpayer No."
                                value="{{ old('nomor_taxpayer') }}">
                            @error('nomor_taxpayer')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <label for="nama_taxpayer" class="col-sm-3 col-form-label ">
                            Name of Taxpayer</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('nama_taxpayer') is-invalid @enderror"
                                id="nama_taxpayer" name="nama_taxpayer" placeholder="Name of Taxpayer"
                                value="{{ old('nama_taxpayer') }}">
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
                                value="{{ old('nomor_bpjs_ketenagakerjaan') }}">
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
                                value="{{ old('iuran_bpjs_ketenagakerjaan') }}">
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
                                placeholder="No BPJS Kesehatan (Yayasan)" value="{{ old('nomor_bpjs_yayasan') }}">
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
                                placeholder="No BPJS Kesehatan (Pribadi)" value="{{ old('nomor_bpjs_pribadi') }}">
                            @error('nomor_bpjs_pribadi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis_kelamin" class="col-sm-3 col-form-label required">Gender</label>
                        <div class="col-sm-3 pt-1">
                            <label class="form-check-label me-3"><input type="radio" name="jenis_kelamin"
                                    value="MALE" @if (old('jenis_kelamin') == 'MALE') checked @endif required>
                                Male</label>
                            <label class="form-check-label me-3"><input type="radio" name="jenis_kelamin"
                                    value="FEMALE" @if (old('jenis_kelamin') == 'FEMALE') checked @endif required>
                                Female</label>
                        </div>
                        <label for="agama" class="col-sm-3 col-form-label required">Religion</label>
                        <div class="col-sm-3">
                            <select class="form-control form-select select2 @error('agama') is-invalid @enderror"
                                name="agama" required>
                                <option value="">-- Select Religion --</option>
                                <option value="1" @if (old('agama') == '1') selected @endif>Islam
                                </option>
                                <option value="2" @if (old('agama') == '2') selected @endif>Protestan
                                </option>
                                <option value="3" @if (old('agama') == '3') selected @endif>Katolik
                                </option>
                                <option value="4" @if (old('agama') == '4') selected @endif>Hindu
                                </option>
                                <option value="5" @if (old('agama') == '5') selected @endif>Budha
                                </option>
                                <option value="6" @if (old('agama') == '6') selected @endif>Khonghucu
                                </option>
                                <option value="7" @if (old('agama') == '7') selected @endif>Lainnya
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
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir"
                                value="{{ old('tempat_lahir') }}">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <label for="tanggal_lahir" class="col-sm-3 col-form-label required">Tanggal
                            Lahir</label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
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
                                placeholder="Address" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat_sekarang" class="col-sm-3 col-form-label required">
                            Current
                            Address</label>
                        <div class="col-sm-9">
                            <textarea class="form-control @error('alamat_sekarang') is-invalid @enderror" id="alamat_sekarang"
                                name="alamat_sekarang" placeholder="Current Address ">{{ old('alamat_sekarang') }}</textarea>
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
                                id="kota" name="kota" placeholder="City" value="{{ old('kota') }}">
                            @error('kota')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <label for="kode_pos" class="col-sm-3 col-form-label ">Pos Code</label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control @error('kode_pos') is-invalid @enderror"
                                id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" placeholder="Pos Code"
                                required>
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
                                id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}"
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
                                value="{{ old('nomor_phone') }}">
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
                                id="email" name="email" placeholder="Email" value="{{ old('email') }}"
                                required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <label for="email_sekolah" class="col-sm-3 col-form-label ">Email
                            School</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('email_sekolah') is-invalid @enderror"
                                id="email_sekolah" name="email_sekolah" value="{{ old('email_sekolah') }}"
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
                                <option value="">-- Select Marital Status --</option>
                                <option value="1" @if (old('status_pernikahan') == 1) selected @endif>Single
                                </option>
                                <option value="2" @if (old('status_pernikahan') == 2) selected @endif>Merried
                                </option>
                                <option value="3" @if (old('status_pernikahan') == 3) selected @endif>Widow
                                </option>
                                <option value="3" @if (old('status_pernikahan') == 3) selected @endif>Widower
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
                            <input type="text" class="form-control @error('nama_pasangan') is-invalid @enderror"
                                id="nama_pasangan" name="nama_pasangan" placeholder="Spouse"
                                value="{{ old('nama_pasangan') }}">
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
                                value="{{ old('jumlah_anak') }}">
                            @error('jumlah_anak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <label for="warga_negara" class="col-sm-3 col-form-label">Citizen</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('warga_negara') is-invalid @enderror"
                                id="warga_negara" name="warga_negara" placeholder="Citizen"
                                value="{{ old('warga_negara') }}">
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
                                placeholder="Note"></textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ttd" class="col-sm-3 col-form-label required">
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
                            <img src="{{ asset('assets/dist/img/preview.png') }}" alt="" id="ttd_preview"
                                width="190px" height="144px">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pas_photo" class="col-sm-3 col-form-label required">
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
                            <img src="{{ asset('assets/dist/img/3x4.png') }}" alt="" id="pas_photo_preview"
                                width="105px" height="144px">
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
                            <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                id="other_document_preview" width="190px" height="144px">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal tambah -->

        {{-- A. Personal Information --}}
        <div class="border-bottom p-2">
            <h6 class="mt-2"><b>A. Personal Information</b></h6>

            <div class="form-group row">
                <label for="nik" class="col-sm-3 col-form-label required">NIK</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                        name="nik" placeholder="NIK" value="{{ $siswa->nik }}" required>
                    @error('nik')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="nis" class="col-sm-3 col-form-label required">NIS</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control @error('nis') is-invalid @enderror" id="nis"
                        name="nis" placeholder="NIS" value="{{ $siswa->nis }}" required>
                    @error('nis')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
                <label for="nisn" class="col-sm-2 col-form-label">NISN</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control @error('nisn') is-invalid @enderror" id="nisn"
                        name="nisn" placeholder="NISN" value="{{ $siswa->nisn }}">
                    @error('nisn')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="nama_lengkap" class="col-sm-3 col-form-label required">Student Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                        id="nama_lengkap" name="nama_lengkap" placeholder="Student Name"
                        value="{{ $siswa->nama_lengkap }}" required>
                    @error('nama_lengkap')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="nama_panggilan" class="col-sm-3 col-form-label required">Nama Panggilan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('nama_panggilan') is-invalid @enderror"
                        id="nama_panggilan" name="nama_panggilan" placeholder="Nama Panggilan"
                        value="{{ $siswa->nama_panggilan }}" required>
                    @error('nama_panggilan')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class=" col-sm-3 col-form-label required">Tingkatan</label>
                <div class="col-sm-3">
                    <select class="form-control form-select select2 @error('tingkatan_id') is-invalid @enderror"
                        id="kelas" name="tingkatan_id" required>
                        <option value="">-- Pilih Tingkatan --</option>
                        @foreach ($data_tingkatan as $tingkatan)
                            <option value="{{ $tingkatan->id }}" @if ($tingkatan->id == $siswa->tingkatan_id) selected @endif>
                                {{ $tingkatan->nama_tingkatan }}</option>
                        @endforeach
                    </select>
                    @error('tingkatan_id')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
                <label class="col-sm-2 col-form-label required">Class</label>
                <div class="col-sm-4">
                    <select class="form-control form-select select2 @error('kelas_id') is-invalid @enderror"
                        id="kelas_id" name="kelas_id" required>
                        <option value="">-- Select Class --</option>
                        @foreach ($data_kelas as $kelas)
                            <option value="{{ $kelas->id }}" @if ($kelas->id == $siswa->kelas_id) selected @endif>
                                {{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="nama_wali" class="col-sm-3 col-form-label required">Jenis
                    Pendaftaran</label>
                <div class="col-sm-3 pt-1">
                    <label class="form-check-label me-3">
                        <input type="radio" name="jenis_pendaftaran" value="1"
                            @if ($siswa->jenis_pendaftaran == '1') checked @endif required>
                        Siswa Baru
                    </label>
                    <label class="form-check-label me-3">
                        <input type="radio" name="jenis_pendaftaran" value="2"
                            @if ($siswa->jenis_pendaftaran == '2') checked @endif required>
                        Pindahan
                    </label>
                </div>

                <label class="col-sm-2 col-form-label required">Jurusan</label>
                <div class="col-sm-4">
                    <select class="form-control form-select select2 @error('jurusan_id') is-invalid @enderror"
                        id="jurusan_id" name="jurusan_id" required>
                        <option value="">-- Select Jurusan --</option>
                        @foreach ($data_jurusan as $jurusan)
                            <option value="{{ $jurusan->id }}" @if ($jurusan->id == $siswa->jurusan_id) selected @endif>
                                {{ $jurusan->nama_jurusan }}</option>
                        @endforeach
                    </select>
                    @error('jurusan_id')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="tahun_masuk" class="col-sm-3 col-form-label required">Tahun Masuk</label>
                <div class="col-sm-3">
                    <input type="text" name="tahun_masuk" id="tahun_masuk"
                        class="form-control @error('tahun_masuk') is-invalid @enderror"
                        value="{{ $siswa->tahun_masuk }}" required>
                    @error('tahun_masuk')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
                <label for="semester_masuk" class="col-sm-2 col-form-label required">Semester Masuk</label>
                <div class="col-sm-4">
                    <input type="text" name="semester_masuk" id="semester_masuk"
                        class="form-control @error('semester_masuk') is-invalid @enderror"
                        value="{{ $siswa->semester_masuk }}" required>
                    @error('semester_masuk')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="kelas_masuk"
                    class="col-sm-3 col-form-label required @error('kelas_masuk') is-invalid @enderror">Kelas
                    Masuk</label>
                <div class="col-sm-3">
                    <input type="text" name="kelas_masuk" id="kelas_masuk" class="form-control"
                        value="{{ $siswa->kelas_masuk }}" required>
                    @error('kelas_masuk')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="jenis_kelamin" class="col-sm-3 col-form-label required">Jenis Kelamin</label>
                <div class="col-sm-3 pt-1">
                    <label class="form-check-label me-3"><input type="radio" name="jenis_kelamin" value="MALE"
                            @if ($siswa->jenis_kelamin == 'MALE') checked @endif required>
                        Male</label>
                    <label class="form-check-label me-3"><input type="radio" name="jenis_kelamin" value="FEMALE"
                            @if ($siswa->jenis_kelamin == 'FEMALE') checked @endif required>
                        Female</label>
                </div>
                <label for="bloodtype" class="col-sm-2 col-form-label">Gol.
                    Darah</label>
                <div class="col-sm-4">
                    <select class="form-control form-select select2 @error('blood_type') is-invalid @enderror"
                        name="blood_type">
                        <option value="">-- Pilih Gol. Darah --</option>
                        <option value="A" @if ($siswa->blood_type == 'A') selected @endif>A
                        </option>
                        <option value="B" @if ($siswa->blood_type == 'B') selected @endif>B
                        </option>
                        <option value="AB" @if ($siswa->blood_type == 'AB') selected @endif>AB
                        </option>
                        <option value="O" @if ($siswa->blood_type == 'O') selected @endif>O
                        </option>
                    </select>
                    @error('blood_type')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="tempat_lahir" class="col-sm-3 col-form-label required">Tempat Lahir</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                        id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir"
                        value="{{ $siswa->tempat_lahir }} " required>
                    @error('tempat_lahir')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
                <label for="tanggal_lahir_edit" class="col-sm-2 col-form-label required">Tanggal Lahir</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        id="tanggal_lahir_edit" name="tanggal_lahir"
                        value="{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '' }}"
                        required>
                    @error('tanggal_lahir')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="agama" class="col-sm-3 col-form-label required">Agama</label>
                <div class="col-sm-3">
                    <select class="form-control form-select select2 @error('agama') is-invalid @enderror"
                        name="agama" required>
                        <option value="">-- Pilih Agama --</option>
                        <option value="1" @if ($siswa->agama == '1') selected @endif>Islam</option>
                        <option value="2" @if ($siswa->agama == '2') selected @endif>Protestan</option>
                        <option value="3" @if ($siswa->agama == '3') selected @endif>Katolik</option>
                        <option value="4" @if ($siswa->agama == '4') selected @endif>Hindu</option>
                        <option value="5" @if ($siswa->agama == '5') selected @endif>Budha</option>
                        <option value="6" @if ($siswa->agama == '6') selected @endif>Khonghucu</option>
                        <option value="7" @if ($siswa->agama == '7') selected @endif>Lainnya</option>
                    </select>
                    @error('agama')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>

                <label for="warga_negara" class="col-sm-2 col-form-label">Warga Negara</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control @error('warga_negara') is-invalid @enderror"
                        id="warga_negara" name="warga_negara" placeholder="Kewarganegaraan"
                        value="{{ $siswa->warga_negara }}">
                    @error('warga_negara')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="jml_saudara_kandung" class="col-sm-3 col-form-label">Jumlah Saudara Kandung</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control @error('jml_saudara_kandung') is-invalid @enderror"
                        id="jml_saudara_kandung" name="jml_saudara_kandung"
                        value="{{ $siswa->jml_saudara_kandung }}">
                    @error('jml_saudara_kandung')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
                <label for="anak_ke" class="col-sm-2 col-form-label">Anak Ke</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control @error('anak_ke') is-invalid @enderror" id="anak_ke"
                        name="anak_ke" value="{{ $siswa->anak_ke }}">
                    @error('anak_ke')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="pas_photo" class="col-sm-3 col-form-label required">Pas Photo</label>
                <div class="col-sm-4 custom-file">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="pas_photo"
                                class="custom-file-input form-control form-control @error('pas_photo') is-invalid @enderror"
                                id="pas_photo" onchange="readURL(this);">
                            @error('pas_photo')
                                <span class="invalid-feedback">{{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    @if (Storage::disk('public')->exists('siswa/' . $siswa->nis . '.jpg'))
                        <img class="mb-2" src="{{ asset('storage/siswa/' . $siswa->nis . '.jpg') }}"
                            alt="{{ $siswa->pas_photo }}" alt="pas_photo" width="105px" id="pas_photo_preview">
                    @else
                        <img src="{{ asset('assets/dist/img/3x4.png') }}" alt="" id="pas_photo_preview"
                            width="105px" height="144px">
                    @endif

                </div>
            </div>
        </div>

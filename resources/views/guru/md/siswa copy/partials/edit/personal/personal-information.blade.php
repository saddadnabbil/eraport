        {{-- A. Personal Information --}}
        <div class="border-bottom p-2">
            <h6 class="mt-2"><b>A. Personal Information</b></h6>

            <div class="form-group row">
                <label for="nik" class="col-sm-3 col-form-label required">NIK</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK"
                        value="{{ $siswa->nik }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="nis" class="col-sm-3 col-form-label required">NIS</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="nis" name="nis" placeholder="NIS"
                        value="{{ $siswa->nis }}" required>
                </div>
                <label for="nisn" class="col-sm-2 col-form-label">NISN</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="nisn" name="nisn" placeholder="NISN"
                        value="{{ $siswa->nisn }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="nama_lengkap" class="col-sm-3 col-form-label required">Student Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                        placeholder="Student Name" value="{{ $siswa->nama_lengkap }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="nama_panggilan" class="col-sm-3 col-form-label required">Nama Panggilan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan"
                        placeholder="Nama Panggilan" value="{{ $siswa->nama_panggilan }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class=" col-sm-3 col-form-label required">Tingkatan</label>
                <div class="col-sm-3">
                    <select class="form-control form-select" id="kelas" name="tingkatan_id" required>
                        <option value="">-- Pilih Tingkatan --</option>
                        @foreach ($data_tingkatan as $tingkatan)
                            <option value="{{ $tingkatan->id }}" @if ($tingkatan->id == $siswa->tingkatan_id) selected @endif>
                                {{ $tingkatan->nama_tingkatan }}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-2 col-form-label required">Class</label>
                <div class="col-sm-4">
                    <select class="form-control form-select" id="kelas_id" name="kelas_id" required>
                        <option value="">-- Select Class --</option>
                        @if ($siswa->kelas)
                            <option value="{{ $siswa->kelas->id }}" selected>
                                {{ $siswa->kelas->nama_kelas }}
                            </option>
                        @endif
                    </select>
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
                    <select class="form-control form-select" id="jurusan_id" name="jurusan_id" required>
                        <option value="">-- Select Class --</option>
                        @if ($siswa->kelas)
                            <option value="{{ $siswa->kelas->jurusan->id }}" selected>
                                {{ $siswa->kelas->jurusan->nama_jurusan }}
                            </option>
                        @endif
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="tahun_masuk" class="col-sm-3 col-form-label required">Tahun Masuk</label>
                <div class="col-sm-3">
                    <input type="text" name="tahun_masuk" id="tahun_masuk" class="form-control"
                        value="{{ $siswa->tahun_masuk }}" required>
                </div>
                <label for="semester_masuk" class="col-sm-2 col-form-label required">Semester Masuk</label>
                <div class="col-sm-4">
                    <input type="text" name="semester_masuk" id="semester_masuk" class="form-control"
                        value="{{ $siswa->semester_masuk }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="kelas_masuk" class="col-sm-3 col-form-label required">Kelas Masuk</label>
                <div class="col-sm-3">
                    <input type="text" name="kelas_masuk" id="kelas_masuk" class="form-control"
                        value="{{ $siswa->kelas_masuk }}" required>
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
                    <select class="form-control form-select" name="blood_type">
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
                </div>
            </div>

            <div class="form-group row">
                <label for="tempat_lahir" class="col-sm-3 col-form-label required">Tempat Lahir</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                        placeholder="Tempat Lahir" value="{{ $siswa->tempat_lahir }} " required>
                </div>
                <label for="tanggal_lahir_edit" class="col-sm-2 col-form-label required">Tanggal Lahir</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="tanggal_lahir_edit" name="tanggal_lahir"
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
               @if (Storage::disk('public')->exists('siswa/' . $siswa->nis . '.jpg'))
                    <img class="mb-2" src="{{ asset('storage/siswa/' . $siswa->nis . '.jpg') }}"
                        id="pas_photo_preview" alt="{{ $siswa->pas_photo }}" alt="pas_photo" width="105px">
                @else
                    <img src="{{ asset('assets/dist/img/3x4.png') }}" alt="" id="pas_photo_preview"
                        width="105px" height="144px">
                    @endif

                </div>
            </div>
        </div>

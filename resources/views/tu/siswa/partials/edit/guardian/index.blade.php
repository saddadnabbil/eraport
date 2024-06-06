<div class="tab-pane" id="guardian2">
    {{-- A. Guardian --}}
    <div class="border-bottom p-2">
        <h6 class="mt-2"><b>A. Guardian</b></h6>
        <div class="form-group row">
            <label for="nik_wali" class="col-sm-3 col-form-label required">NIK</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('nik_wali') is-invalid @enderror" id="nik_wali"
                    name="nik_wali" placeholder="NIK" value="{{ $siswa->nik_wali }}" required>
                @error('nik_wali')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="nama_wali" class="col-sm-3 col-form-label required">Nama</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('nama_wali') is-invalid @enderror" id="nama_wali"
                    name="nama_wali" placeholder="Nama" value="{{ $siswa->nama_wali }}" required>
                @error('nama_wali')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="tempat_lahir_wali" class="col-sm-3 col-form-label">Tempat Lahir</label>
            <div class="col-sm-3">
                <input type="text" class="form-control @error('tempat_lahir_wali') is-invalid @enderror"
                    id="tempat_lahir_wali" name="tempat_lahir_wali" placeholder="Tempat Lahir"
                    value="{{ $siswa->tempat_lahir_wali }}">
                @error('tempat_lahir_wali')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
            <label for="tanggal_lahir_wali" class="col-sm-3 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-3">
                <input type="date" class="form-control @error('tanggal_lahir_wali') is-invalid @enderror"
                    id="tanggal_lahir_wali" name="tanggal_lahir_wali" placeholder="Tanggal Lahir"
                    value="{{ $siswa->tanggal_lahir_wali ? \Carbon\Carbon::parse($siswa->tanggal_lahir_wali)->format('Y-m-d') : '' }}">
                @error('tanggal_lahir_wali')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="alamat_wali" class="col-sm-3 col-form-label">Address</label>
            <div class="col-sm-9">
                <textarea class="form-control @error('alamat_wali') is-invalid @enderror" id="alamat_wali" name="alamat_wali"
                    placeholder="Address">{{ $siswa->alamat_wali }}</textarea>
                @error('alamat_wali')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="nomor_hp_wali" class="col-sm-3 col-form-label">Phone</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('nomor_hp_wali') is-invalid @enderror"
                    id="nomor_hp_wali" name="nomor_hp_wali" placeholder="Phone" value="{{ $siswa->nomor_hp_wali }}">
                @error('nomor_hp_wali')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="agama_wali" class="col-sm-3 col-form-label">Agama</label>
            <div class="col-sm-9">
                <select class="form-control form-select @error('agama_wali') is-invalid @enderror" id="agama_wali"
                    name="agama_wali">
                    <option selected>-- Pilih Agama --</option>
                    <option value="1" @if ($siswa->agama_wali == '1') selected @endif>Islam</option>
                    <option value="2" @if ($siswa->agama_wali == '2') selected @endif>Kristen</option>
                    <option value="3" @if ($siswa->agama_wali == '3') selected @endif>Katolik</option>
                    <option value="4" @if ($siswa->agama_wali == '4') selected @endif>Hindu</option>
                    <option value="5" @if ($siswa->agama_wali == '5') selected @endif>Budha</option>
                    <option value="6" @if ($siswa->agama_wali == '6') selected @endif>Khonghucu</option>
                    <option value="7" @if ($siswa->agama_wali == '7') selected @endif>Lainnya</option>
                </select>
                @error('agama_wali')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="kota_wali" class="col-sm-3 col-form-label">Kota</label>
            <div class="col-sm-3">
                <input type="text" class="form-control @error('kota_wali') is-invalid @enderror" id="kota_wali"
                    name="kota_wali" placeholder="Kota" value="{{ $siswa->kota_wali }}">
                @error('kota_wali')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
            <label for="pendidikan_terakhir_wali" class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
            <div class="col-sm-3">
                <input type="text" class="form-control @error('pendidikan_terakhir_wali') is-invalid @enderror"
                    id="pendidikan_terakhir_wali" name="pendidikan_terakhir_wali" placeholder="Pendidikan Terakhir"
                    value="{{ $siswa->pendidikan_terakhir_wali }}">
                @error('pendidikan_terakhir_wali')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="pekerjaan_wali" class="col-sm-3 col-form-label required">Pekerjaan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('pekerjaan_wali') is-invalid @enderror"
                    id="pekerjaan_wali" name="pekerjaan_wali" placeholder="Pekerjaan"
                    value="{{ $siswa->pekerjaan_wali }}" required>
                @error('pekerjaan_wali')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="penghasil_wali" class="col-sm-3 col-form-label">Penghasilan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('penghasil_wali') is-invalid @enderror"
                    id="penghasil_wali" name="penghasil_wali" placeholder="Penghasilan"
                    value="{{ $siswa->penghasil_wali }}">
                @error('penghasil_wali')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    </div>
</div>

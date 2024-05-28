<div class="tab-pane" id="mother2">
    {{-- A. Mother --}}
    <div class="border-bottom p-2">
        <h6 class="mt-2"><b>A. Mother</b></h6>
        <div class="form-group row">
            <label for="nik_ibu" class="col-sm-3 col-form-label required">NIK</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('nik_ibu') is-invalid @enderror" id="nik_ibu"
                    name="nik_ibu" placeholder="NIK" value="{{ $siswa->nik_ibu }}" required>
                @error('nik_ibu')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="nama_ayah" class="col-sm-3 col-form-label required">Nama</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" id="nama_ibu"
                    name="nama_ibu" placeholder="Nama" value="{{ $siswa->nama_ibu }}" required>
                @error('nama_ibu')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="tempat_lahir_ibu" class="col-sm-3 col-form-label">Tempat Lahir</label>
            <div class="col-sm-3">
                <input type="text" class="form-control @error('tempat_lahir_ibu') is-invalid @enderror"
                    id="tempat_lahir_ibu" name="tempat_lahir_ibu" placeholder="Tempat Lahir"
                    value="{{ $siswa->tempat_lahir_ibu }}">
                @error('tempat_lahir_ibu')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror

            </div>
            <label for="tanggal_lahir_ibu" class="col-sm-3 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-3">
                <input type="date" class="form-control @error('tanggal_lahir_ibu') is-invalid @enderror"
                    id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" placeholder="Tanggal Lahir"
                    value="{{ $siswa->tanggal_lahir_ibu ? \Carbon\Carbon::parse($siswa->tanggal_lahir_ibu)->format('Y-m-d') : '' }}">
                @error('tanggal_lahir_ibu')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="alamat_ibu" class="col-sm-3 col-form-label">Address</label>
            <div class="col-sm-9">
                <textarea class="form-control @error('alamat_ibu') is-invalid @enderror" id="alamat_ibu" name="alamat_ibu"
                    placeholder="Address">{{ $siswa->alamat_ibu }}</textarea>
                @error('alamat_ibu')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="nomor_hp_ibu" class="col-sm-3 col-form-label">Phone</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('nomor_hp_ibu') is-invalid @enderror" id="nomor_hp_ibu"
                    name="nomor_hp_ibu" placeholder="Phone" value="{{ $siswa->nomor_hp_ibu }}">
                @error('nomor_hp_ibu')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="agama_ibu" class="col-sm-3 col-form-label">Agama</label>
            <div class="col-sm-9">
                <select class="form-control form-select  @error('agama_ibu') is-invalid @enderror" id="agama_ibu"
                    name="agama_ibu">
                    <option selected>-- Pilih Agama --</option>
                    <option value="1" @if ($siswa->agama_ibu == '1') selected @endif>Islam</option>
                    <option value="2" @if ($siswa->agama_ibu == '2') selected @endif>Kristen</option>
                    <option value="3" @if ($siswa->agama_ibu == '3') selected @endif>Katolik</option>
                    <option value="4" @if ($siswa->agama_ibu == '4') selected @endif>Hindu</option>
                    <option value="5" @if ($siswa->agama_ibu == '5') selected @endif>Budha</option>
                    <option value="6" @if ($siswa->agama_ibu == '6') selected @endif>Khonghucu</option>
                    <option value="7" @if ($siswa->agama_ibu == '7') selected @endif>Lainnya</option>
                </select>
                @error('agama_ibu')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="kota_ibu" class="col-sm-3 col-form-label">Kota</label>
            <div class="col-sm-3">
                <input type="text" class="form-control @error('kota_ibu') is-invalid @enderror" id="kota_ibu"
                    name="kota_ibu" placeholder="Kota" value="{{ $siswa->kota_ibu }}">
                @error('kota_ibu')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
            <label for="pendidikan_terakhir_ibu" class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
            <div class="col-sm-3">
                <input type="text" class="form-control @error('pendidikan_terakhir_ibu') is-invalid @enderror"
                    id="pendidikan_terakhir_ibu" name="pendidikan_terakhir_ibu" placeholder="Pendidikan Terakhir"
                    value="{{ $siswa->pendidikan_terakhir_ibu }}">
                @error('pendidikan_terakhir_ibu')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="pekerjaan_ibu" class="col-sm-3 col-form-label required">Pekerjaan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                    id="pekerjaan_ibu" name="pekerjaan_ibu" placeholder="Pekerjaan Ayah"
                    value="{{ $siswa->pekerjaan_ibu }}" required>
                @error('pekerjaan_ibu')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="penghasil_ibu" class="col-sm-3 col-form-label">Penghasilan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('penghasil_ibu') is-invalid @enderror"
                    id="penghasil_ibu" name="penghasil_ibu" placeholder="Penghasilan"
                    value="{{ $siswa->penghasil_ibu }}">
                @error('penghasil_ibu')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="tab-pane" id="father2">
    {{-- A. Father --}}
    <div class="border-bottom p-2">
        <h6 class="mt-2"><b>A. Father</b></h6>
        <div class="form-group row">
            <label for="nik_ayah" class="col-sm-3 col-form-label required">NIK</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('nik_ayah') is-invalid @enderror" id="nik_ayah"
                    name="nik_ayah" placeholder="NIK" value="{{ $siswa->nik_ayah }}" required>
                @error('nik_ayah')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="nama_ayah" class="col-sm-3 col-form-label required">Nama</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" id="nama_ayah"
                    name="nama_ayah" placeholder="Nama" value="{{ $siswa->nama_ayah }}" required>
                @error('nama_ayah')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="tempat_lahir_ayah" class="col-sm-3 col-form-label">Tempat Lahir</label>
            <div class="col-sm-3">
                <input type="text" class="form-control @error('tempat_lahir_ayah') is-invalid @enderror"
                    id="tempat_lahir_ayah" name="tempat_lahir_ayah" placeholder="Tempat Lahir"
                    value="{{ $siswa->tempat_lahir_ayah }}">
                @error('tempat_lahir_ayah')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
            <label for="tanggal_lahir_ayah" class="col-sm-3 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-3">
                <input type="date" class="form-control @error('tanggal_lahir_ayah') is-invalid @enderror"
                    id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" placeholder="Tanggal Lahir"
                    value="{{ $siswa->tanggal_lahir_ayah ? \Carbon\Carbon::parse($siswa->tanggal_lahir_ayah)->format('Y-m-d') : '' }}">
                @error('tanggal_lahir_ayah')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="alamat_ayah" class="col-sm-3 col-form-label">Address</label>
            <div class="col-sm-9">
                <textarea class="form-control @error('alamat_ayah') is-invalid @enderror" id="alamat_ayah" name="alamat_ayah"
                    placeholder="Address">{{ $siswa->alamat_ayah }}</textarea>
                @error('alamat_ayah')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="nomor_hp_ayah" class="col-sm-3 col-form-label">Phone</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('nomor_hp_ayah') is-invalid @enderror"
                    id="nomor_hp_ayah" name="nomor_hp_ayah" placeholder="Phone" value="{{ $siswa->nomor_hp_ayah }}">
                @error('nomor_hp_ayah')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="agama_ayah" class="col-sm-3 col-form-label">Agama</label>
            <div class="col-sm-9">
                <select class="form-control form-select @error('agama_ayah') is-invalid @enderror" id="agama_ayah"
                    name="agama_ayah">
                    <option selected>-- Pilih Agama --</option>
                    <option value="1" @if ($siswa->agama_ayah == 1) selected @endif>Islam</option>
                    <option value="2" @if ($siswa->agama_ayah == 2) selected @endif>Kristen</option>
                    <option value="3" @if ($siswa->agama_ayah == 3) selected @endif>Katolik</option>
                    <option value="4" @if ($siswa->agama_ayah == 4) selected @endif>Hindu</option>
                    <option value="5" @if ($siswa->agama_ayah == 5) selected @endif>Budha</option>
                    <option value="6" @if ($siswa->agama_ayah == 6) selected @endif>Khonghucu</option>
                    <option value="7" @if ($siswa->agama_ayah == 7) selected @endif>Lainnya</option>
                </select>
                @error('agama_ayah')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="kota_ayah" class="col-sm-3 col-form-label">Kota</label>
            <div class="col-sm-3">
                <input type="text" class="form-control @error('kota_ayah') is-invalid @enderror" id="kota_ayah"
                    name="kota_ayah" placeholder="Kota" value="{{ $siswa->kota_ayah }}">
                @error('kota_ayah')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
            <label for="pendidikan_terakhir_ayah" class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
            <div class="col-sm-3">
                <input type="text" class="form-control @error('pendidikan_terakhir_ayah') is-invalid @enderror"
                    id="pendidikan_terakhir_ayah" name="pendidikan_terakhir_ayah" placeholder="Pendidikan Terakhir"
                    value="{{ $siswa->pendidikan_terakhir_ayah }}">
                @error('pendidikan_terakhir_ayah')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="pekerjaan_ayah" class="col-sm-3 col-form-label required">Pekerjaan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                    id="pekerjaan_ayah" name="pekerjaan_ayah" placeholder="Pekerjaan"
                    value="{{ $siswa->pekerjaan_ayah }}" required>
                @error('pekerjaan_ayah')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="penghasil_ayah" class="col-sm-3 col-form-label">Penghasilan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @error('penghasil_ayah') is-invalid @enderror"
                    id="penghasil_ayah" name="penghasil_ayah" placeholder="Penghasilan"
                    value="{{ $siswa->penghasil_ayah }}">
                @error('penghasil_ayah')
                    <span class="invalid-feedback">{{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    </div>
</div>

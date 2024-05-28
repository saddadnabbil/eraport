{{-- B. Domicile Information --}}
<div class="border-bottom mt-3 p-2">
    <h6 class="mt-2"><b>B. Domicile Information</b></h6>

    <div class="form-group row">
        <label for="alamat" class="col-sm-3 col-form-label">Address</label>
        <div class="col-sm-9">
            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                placeholder="Address lengkap">{{ $siswa->alamat }}</textarea>
            @error('alamat')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="kota" class="col-sm-3 col-form-label">Kota</label>
        <div class="col-sm-4">
            <input type="text" class="form-control @error('kota') is-invalid @enderror" id="kota" name="kota"
                placeholder="Kota" value="{{ $siswa->kota }}">
            @error('kota')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
        <label for="kode_pos" class="col-sm-2 col-form-label">Postal Code</label>
        <div class="col-sm-3">
            <input type="number" class="form-control @error('kode_pos') is-invalid @enderror" id="kode_pos"
                name="kode_pos" placeholder="Postal Code" value="{{ $siswa->kode_pos }}">
            @error('kode_pos')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="jarak_rumah_ke_sekolah" class="col-sm-3 col-form-label">Jarak Rumah ke Sekolah (km)</label>
        <div class="col-sm-9">
            <input type="number" name="jarak_rumah_ke_sekolah" id="jarak_rumah_ke_sekolah"
                placeholder="Jarak Rumah ke Sekola (km)"
                class="form-control @error('jarak_rumah_ke_sekolah') is-invalid @enderror"
                value="{{ $siswa->jarak_rumah_ke_sekolah }}">
            @error('jarak_rumah_ke_sekolah')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" placeholder="Email" value="{{ $siswa->email }}">
            @error('email')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="email_parent" class="col-sm-3 col-form-label">Email Parent</label>
    <div class="col-sm-9">
        <input type="email" class="form-control @error('email_parent') is-invalid @enderror" id="email_parent"
            name="email_parent" placeholder="Email Parent" value="{{ $siswa->email_parent }}">
        @error('email_parent')
            <span class="invalid-feedback">{{ $message }}
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="nomor_hp" class="col-sm-3 col-form-label">Phone</label>
    <div class="col-sm-9">
        <input type="number" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp"
            name="nomor_hp" placeholder="Phone" value="{{ $siswa->nomor_hp }}">
        @error('nomor_hp')
            <span class="invalid-feedback">{{ $message }}
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="tinggal_bersama" class="col-sm-3 col-form-label">Tinggal Bersama</label>
    <div class="col-sm-4">
        <select class="form-control form-select @error('tinggal_bersama') is-invalid @enderror" name="tinggal_bersama">
            <option value="">-- Pilih Tinggal Bersama --</option>
            <option value="Parents" @if ($siswa->tinggal_bersama == 'Parents') selected @endif>Parents</option>
            <option value="Others" @if ($siswa->tinggal_bersama == 'Others') selected @endif>Others</option>
        </select>
        @error('tinggal_bersama')
            <span class="invalid-feedback">{{ $message }}
            </span>
        @enderror
    </div>
    <label for="transportasi" class="col-sm-2 col-form-label">Transportasi</label>
    <div class="col-sm-3">
        <input type="text" class="form-control @error('transportasi') is-invalid @enderror" id="transportasi"
            name="transportasi" placeholder="Transportasi" value="{{ old('transportasi') }}">
        @error('transportasi')
            <span class="invalid-feedback">{{ $message }}
            </span>
        @enderror
    </div>
</div>

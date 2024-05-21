{{-- B. Domicile Information --}}
<div class="border-bottom mt-3 p-2">
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
            <input type="text" class="form-control" id="kota" name="kota" placeholder="Kota"
                value="{{ $siswa->kota }}">
        </div>
        <label for="kode_pos" class="col-sm-2 col-form-label">Kode Pos</label>
        <div class="col-sm-3">
            <input type="number" class="form-control" id="kode_pos" name="kode_pos" placeholder="Kode Pos"
                value="{{ $siswa->kode_pos }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="jarak_rumah_ke_sekolah" class="col-sm-3 col-form-label">Jarak Rumah ke Sekolah (km)</label>
        <div class="col-sm-9">
            <input type="number" name="jarak_rumah_ke_sekolah" id="jarak_rumah_ke_sekolah"
                placeholder="Jarak Rumah ke Sekola (km)" class="form-control"
                value="{{ $siswa->jarak_rumah_ke_sekolah }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                value="{{ $siswa->email }}">
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="email_parent" class="col-sm-3 col-form-label">Email Parent</label>
    <div class="col-sm-9">
        <input type="email" class="form-control" id="email_parent" name="email_parent" placeholder="Email Parent"
            value="{{ $siswa->email_parent }}">
    </div>
</div>
<div class="form-group row">
    <label for="nomor_hp" class="col-sm-3 col-form-label">Nomor HP</label>
    <div class="col-sm-9">
        <input type="number" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Nomor HP"
            value="{{ $siswa->nomor_hp }}">
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
        <input type="text" class="form-control" id="transportasi" name="transportasi" placeholder="Transportasi"
            value="{{ old('transportasi') }}">
    </div>
</div>

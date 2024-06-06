{{-- D. Previously Formal School --}}
<div class="mt-3 p-2">
    <h6 class="mt-2"><b>D. Previously Formal School</b></h6>

    <div class="form-group row">
        <label for="tanggal_masuk_sekolah_lama" class="col-sm-3 col-form-label">Tgl. Masuk Sekolah</label>
        <div class="col-sm-4">
            <input type="date" class="form-control  @error('tanggal_masuk_sekolah_lama') is-invalid @enderror"
                id="tanggal_masuk_sekolah_lama" name="tanggal_masuk_sekolah_lama"
                value="{{ $siswa->tanggal_masuk_sekolah_lama ? \Carbon\Carbon::parse($siswa->tanggal_masuk_sekolah_lama)->format('Y-m-d') : '' }}">
            @error('tanggal_masuk_sekolah_lama')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
        <label for="tanggal_keluar_sekolah_lama" class="col-sm-2 col-form-label">Tgl. Keluar Sekolah</label>
        <div class="col-sm-3">
            <input type="date" class="form-control  @error('tanggal_keluar_sekolah_lama') is-invalid @enderror"
                id="tanggal_keluar_sekolah_lama" name="tanggal_keluar_sekolah_lama"
                value="{{ $siswa->tanggal_keluar_sekolah_lama ? \Carbon\Carbon::parse($siswa->tanggal_keluar_sekolah_lama)->format('Y-m-d') : '' }}">
            @error('tanggal_keluar_sekolah_lama')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="nama_sekolah_lama" class="col-sm-3 col-form-label">School Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control  @error('nama_sekolah_lama') is-invalid @enderror"
                id="nama_sekolah_lama" name="nama_sekolah_lama" placeholder="School Name"
                value="{{ $siswa->nama_sekolah_lama }}">
            @error('nama_sekolah_lama')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="prestasi_sekolah_lama" class="col-sm-3 col-form-label">Prestasi </label>
        <div class="col-sm-3">
            <input type="text" class="form-control  @error('prestasi_sekolah_lama') is-invalid @enderror"
                id="prestasi_sekolah_lama" name="prestasi_sekolah_lama" placeholder="Prestasi"
                value="{{ $siswa->prestasi_sekolah_lama }}">
            @error('prestasi_sekolah_lama')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
        <label for="tahun_prestasi_sekolah_lama" class="col-sm-2 col-form-label">Tahun Prestasi </label>
        <div class="col-sm-4">
            <input type="text" class="form-control  @error('tahun_prestasi_sekolah_lama') is-invalid @enderror"
                id="tahun_prestasi_sekolah_lama" name="tahun_prestasi_sekolah_lama" placeholder="Tahun Prestasi"
                value="{{ $siswa->tahun_prestasi_sekolah_lama }}">
            @error('tahun_prestasi_sekolah_lama')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="sertifikat_number_sekolah_lama" class="col-sm-3 col-form-label">Sertifikat Number</label>
        <div class="col-sm-9">
            <input type="text" class="form-control  @error('sertifikat_number_sekolah_lama') is-invalid @enderror"
                id="sertifikat_number_sekolah_lama" name="sertifikat_number_sekolah_lama" placeholder="Sertikat Number"
                value="{{ $siswa->sertifikat_number_sekolah_lama }}">
            @error('sertifikat_number_sekolah_lama')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="alamat_sekolah_lama" class="col-sm-3 col-form-label">Address Sekolah</label>
        <div class="col-sm-9">
            <input type="text" class="form-control  @error('alamat_sekolah_lama') is-invalid @enderror"
                id="alamat_sekolah_lama" name="alamat_sekolah_lama" placeholder="Address Sekolah"
                value="{{ $siswa->alamat_sekolah_lama }}">
            @error('alamat_sekolah_lama')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="no_sttb" class="col-sm-3 col-form-label">No. STTB</label>
        <div class="col-sm-3">
            <input type="text" class="form-control  @error('no_sttb') is-invalid @enderror" id="no_sttb"
                name="no_sttb" placeholder="No. STTB" value="{{ $siswa->no_sttb }}">
            @error('no_sttb')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
        <label for="nem" class="col-sm-3 col-form-label">NEM</label>
        <div class="col-sm-3">
            <input type="number" class="form-control  @error('nem') is-invalid @enderror" id="nem" name="nem"
                placeholder="NEM" value="{{ $siswa->nem }}">
            @error('nem')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="file_dokument_sekolah_lama" class="col-sm-3 col-form-label">File Dokument Sekolah
            Lama</label>
        <div class="col-sm-9 custom-file">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="file_dokument_sekolah_lama"
                        class="custom-file-input form-control form-control  @error('file_dokument_sekolah_lama') is-invalid @enderror"
                        id="file_dokument_sekolah_lama">
                    @error('nem')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

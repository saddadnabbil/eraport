{{-- C. Student Medical Condition --}}
<div class="border-bottom mt-3 p-2">
    <h6 class="mt-2"><b>C. Student Medical Condition</b></h6>

    <div class="form-group row">
        <label for="tinggi_badan" class="col-sm-3 col-form-label">Tinggi Badan</label>
        <div class="col-sm-4">
            <input type="text" class="form-control @error('tinggi_badan') is-invalid @enderror" id="tinggi_badan"
                name="tinggi_badan" placeholder="Tinggi Badan" value="{{ $siswa->tinggi_badan }}">
            @error('tinggi_badan')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
        <label for="berat_badan" class="col-sm-2 col-form-label">Berat Badan</label>
        <div class="col-sm-3">
            <input type="text" class="form-control @error('berat_badan') is-invalid @enderror" id="berat_badan"
                name="berat_badan" placeholder="Berat Badan" value="{{ $siswa->berat_badan }}">
            @error('berat_badan')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="spesial_treatment" class="col-sm-3 col-form-label">Spesial Treatment</label>
        <div class="col-sm-9">
            <input type="text" class="form-control @error('spesial_treatment') is-invalid @enderror"
                id="spesial_treatment" name="spesial_treatment" placeholder="Spesial Treatment"
                value="{{ $siswa->spesial_treatment }}">
            @error('spesial_treatment')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="note_kesehatan" class="col-sm-3 col-form-label">Note Kesehatan</label>
        <div class="col-sm-9">
            <input type="text" class="form-control @error('note_kesehatan') is-invalid @enderror" id="note_kesehatan"
                name="note_kesehatan" placeholder="Note Kesehatan" value="{{ $siswa->note_kesehatan }}">
            @error('note_kesehatan')
                <span class="invalid-feedback">{{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="file_document_kesehatan" class="col-sm-3 col-form-label">File Document Kesehatan</label>
        <div class="col-sm-9 custom-file">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="file_document_kesehatan"
                        class="custom-file-input form-control @error('file_document_kesehatan') is-invalid @enderror"
                        id="file_document_kesehatan">
                    @error('file_document_kesehatan')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="file_list_pertanyaan" class="col-sm-3 col-form-label">File List Pertanyaan</label>
        <div class="col-sm-9 custom-file">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="file_list_pertanyaan"
                        class="custom-file-input form-control form-control @error('file_list_pertanyaan') is-invalid @enderror"
                        id="file_list_pertanyaan">
                    @error('file_list_pertanyaan')
                        <span class="invalid-feedback">{{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

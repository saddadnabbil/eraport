{{-- C. Student Medical Condition --}}
<div class="border-bottom mt-3 p-2">
    <h6 class="mt-2"><b>C. Student Medical Condition</b></h6>

    <div class="form-group row">
        <label for="tinggi_badan" class="col-sm-3 col-form-label">Tinggi Badan</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="tinggi_badan" name="tinggi_badan"
                placeholder="Tinggi Badan" value="{{ $siswa->tinggi_badan }}">
        </div>
        <label for="berat_badan" class="col-sm-2 col-form-label">Berat Badan</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="berat_badan" name="berat_badan"
                placeholder="Berat Badan" value="{{ $siswa->berat_badan }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="spesial_treatment" class="col-sm-3 col-form-label">Spesial Treatment</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="spesial_treatment" name="spesial_treatment"
                placeholder="Spesial Treatment" value="{{ $siswa->spesial_treatment }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="note_kesehatan" class="col-sm-3 col-form-label">Note Kesehatan</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="note_kesehatan" name="note_kesehatan"
                placeholder="Note Kesehatan" value="{{ $siswa->note_kesehatan }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="file_document_kesehatan" class="col-sm-3 col-form-label">File Document Kesehatan</label>
        <div class="col-sm-9 custom-file">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="file_document_kesehatan"
                        class="custom-file-input form-control form-control" id="file_document_kesehatan">
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
                        class="custom-file-input form-control form-control" id="file_list_pertanyaan">
                </div>
            </div>
        </div>
    </div>
</div>

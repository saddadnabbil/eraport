<!-- Modal import  -->
<div class="modal fade" id="modal-import">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import {{ $title }}</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-hidden="true"></button>
                </button>
            </div>
            <form name="import-karyawan" action="{{ route('karyawan.import') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="callout callout-info">
                        <h5>Download format import</h5>
                        <p>Silahkan download file format import melalui tombol dibawah ini.</p>
                        <a href="{{ route('karyawan.format_import') }}"
                            class="btn btn-primary text-white" style="text-decoration:none"><i
                                class="fas fa-file-download"></i> Download</a>
                    </div>
                    <div class="form-group row pt-2">
                        <label for="file_import" class="col-sm-2 col-form-label">File Import</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input type="file"
                                    class="custom-file-input form-control form-control"
                                    name="file_import" id="customFile"
                                    accept="application/vnd.ms-excel" required>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-default"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary position-relative">
                        <div class="spinner-border spinner-border-sm" role="status" id="loading"
                            style="display: none">
                            <span class="sr-only">Loading...</span>
                        </div>
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal import -->
<!-- Modal tambah  -->
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create {{ $title }}</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </button>
            </div>
            <form action="{{ route('admin.tingkatan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="tahun_pelajaran" class="col-sm-3 col-form-label">School Name</label>
                        <div class="col-sm-9">
                            <select name="sekolah_id" id="sekolah_id" class="form-control form-select select2" required>
                                <option value="">Select School</option>
                                @foreach ($data_sekolah as $item)
                                    <option value="{{ old('sekolah_id', $item->id) }}"
                                        @if (old('sekolah_id') == $item->id) selected @endif>{{ $item->nama_sekolah }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sekolah_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tahun_pelajaran" class="col-sm-3 col-form-label">Level Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('nama_tingkatan') is-invalid @enderror"
                                id="nama_tingkatan" name="nama_tingkatan" placeholder="Level Name"
                                value="{{ old('nama_tingkatan') }}" required>
                            @error('nama_tingkatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="term_id" class="col-sm-3 col-form-label">Term</label>
                        <div class="col-sm-9">
                            <select class="form-control form-select select2 @error('term_id') is-invalid @enderror"
                                name="term_id" id="term_id">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                            @error('term_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="semester_id" class="col-sm-3 col-form-label">Semester</label>
                        <div class="col-sm-9">
                            <select class="form-control form-select select2 @error('term_id') is-invalid @enderror"
                                name="semester_id" id="semester_id">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                            @error('term_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal tambah -->

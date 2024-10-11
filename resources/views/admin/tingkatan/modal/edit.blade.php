<!-- Modal edit  -->
<div class="modal fade" id="modal-edit{{ $tingkatan->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit {{ $title }}</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{ route('admin.tingkatan.update', $tingkatan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="term_id" value="{{ $tingkatan->term_id }}">
                <input type="hidden" name="semester_id" value="{{ $tingkatan->semester_id }}">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="tahun_pelajaran" class="col-sm-3 col-form-label">School Name</label>
                        <div class="col-sm-9">
                            <select name="sekolah_id" id="sekolah_id" class="form-control form-select select2" required>
                                <option value="">Select School</option>
                                @foreach ($data_sekolah as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($tingkatan->sekolah_id == $item->id) selected @endif>{{ $item->nama_sekolah }}
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
                                value="{{ $tingkatan->nama_tingkatan }}" required>
                            @error('nama_tingkatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal edit -->

<form action="{{ route('profilesiswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
    {{ method_field('PATCH') }}
    @csrf
    <div class="modal-body">
        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
            <li class="nav-item">
                <a href="#student2" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                    <i class="mdi mdi-home-variant d-lg-none d-block me-1"></i>
                    <span class="d-block">Student</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#father2" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 ">
                    <i class="mdi mdi-account-circle d-lg-none d-block me-1"></i>
                    <span class="d-block">Father</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#mother2" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                    <i class="mdi mdi-account-circle d-lg-none d-block me-1"></i>
                    <span class="d-block">Mother</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#guardian2" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                    <i class="mdi mdi-settings-outline d-lg-none d-block me-1"></i>
                    <span class="d-block">Guardian</span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            @include('siswa.profile.partials.edit.personal.index')
            @include('siswa.profile.partials.edit.father.index')
            @include('siswa.profile.partials.edit.mother.index')
            @include('siswa.profile.partials.edit.guardian.index')
        </div>

        <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>

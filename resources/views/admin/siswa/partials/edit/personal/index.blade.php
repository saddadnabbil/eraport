<div class="tab-pane show active" id="student2">
    <div class="border-bottom p-2">
        <h6 class="mt-2"><b>Authentication User</b></h6>
        {{-- username --}}
        <div class="form-group row">
            <label for="username" class="col-sm-3 col-form-label ">Username</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                    value="{{ $siswa->user->username }}" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="password_lama" class="col-sm-3 col-form-label">Password Lama</label>
            <div class="col-sm-3">
                <input type="password" class="form-control" id="password_lama" name="password_lama"
                    placeholder="Password Lama" value="">
            </div>
            <label for="password_baru" class="col-sm-2 col-form-label ">Password
                Baru</label>
            <div class="col-sm-4">
                <input type="password" class="form-control" id="password_baru" name="password_baru"
                    placeholder="Password Baru" value="">
            </div>
        </div>
    </div>
    @include('admin.siswa.partials.edit.personal.personal-information')
    @include('admin.siswa.partials.edit.personal.domicile-information')
    @include('admin.siswa.partials.edit.personal.student-medical-information')
    @include('admin.siswa.partials.edit.personal.student-previous-school-information')
</div>

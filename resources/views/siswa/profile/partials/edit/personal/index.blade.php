<div class="tab-pane show active" id="student2">
    <div class="border-bottom p-2">
        <h6 class="mt-2"><b>Authentication User</b></h6>
        {{-- username --}}
        <div class="form-group row">
            <label for="username" class="col-sm-3 col-form-label ">Username</label>
            <div class="col-sm-9">
                <input type="text" class="form-control @if ($errors->has('username')) is-invalid @endif"
                    id="username" name="username" placeholder="Username" value="{{ $siswa->user->username }}" required>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password_lama" class="col-sm-3 col-form-label">Password Lama</label>
            <div class="col-sm-3">
                <input type="password" class="form-control @if ($errors->has('password_lama')) is-invalid @endif"
                    id="password_lama" name="password_lama" placeholder="Password Lama" value="">
                @error('password_lama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <label for="password_baru" class="col-sm-2 col-form-label ">Password
                Baru</label>
            <div class="col-sm-4">
                <input type="password" class="form-control @if ($errors->has('password_baru')) is-invalid @endif"
                    id="password_baru" name="password_baru" placeholder="Password Baru" value="">
                @error('password_baru')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    @include('siswa.profile.partials.edit.personal.personal-information')
    @include('siswa.profile.partials.edit.personal.domicile-information')
    @include('siswa.profile.partials.edit.personal.student-medical-information')
    @include('siswa.profile.partials.edit.personal.student-previous-school-information')
</div>

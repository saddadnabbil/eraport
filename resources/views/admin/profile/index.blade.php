@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.admin')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @include('layouts.partials.breadcrumbs._breadcrumbs-item', [
            'titleBreadCrumb' => $title,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('dashboard'),
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => route('user.index'),
                    'active' => false,
                ],
            ],
        ])
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if (Auth::user()->karyawan && Auth::user()->karyawan->avatar)
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="/assets/dist/img/avatar/{{ Auth::user()->karyawan->avatar }}" alt="Avatar"
                                        style="border: none">
                                @else
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="/assets/dist/img/avatar/default.png" alt="Avatar" style="border: none">
                                @endif
                            </div>

                            <h3 class="profile-username text-center">{{ $admin->nama_lengkap }}</h3>

                            <p class="text-muted text-center">Administrator</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Username</b> <a class="float-right">{{ $admin->user->username }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ $admin->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Nomor HP</b> <a class="float-right">{{ $admin->nomor_hp }}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> Data Pribadi</h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ route('profileadmin.update', $admin->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Full name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_lengkap"
                                            value="{{ $admin->nama_lengkap }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-10 pt-1">
                                        <label class="form-check-label me-3"><input type="radio" name="jenis_kelamin"
                                                value="Male" @if ($admin->jenis_kelamin == 'Male') checked @endif required>
                                            Laki-Laki</label>
                                        <label class="form-check-label me-3"><input type="radio" name="jenis_kelamin"
                                                value="Female" @if ($admin->jenis_kelamin == 'Female') checked @endif required>
                                            Perempuan</label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="tanggal_lahir"
                                            value="{{ $admin->tanggal_lahir }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email </label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $admin->email }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nomor HP </label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="nomor_hp"
                                            value="{{ $admin->nomor_hp }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Foto Profile </label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input form-control" name="avatar"
                                                id="customFile" accept="image/*">
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div>
                                            <label>
                                                <input type="checkbox" required> Edit identitas saya
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('footer')
    @include('layouts.main.footer')
@endsection

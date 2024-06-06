@extends('layouts.main.header')

@section('sidebar')
    @include('layouts.sidebar.guru')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            $dashboard = route('guru.dashboard');
        @endphp
        @include('layouts.partials.breadcrumbs._breadcrumbs-item', [
            'titleBreadCrumb' => $title,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => $dashboard,
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
                                <img class="profile-user-img img-fluid img-circle"
                                    src="/assets/dist/img/avatar/{{ Auth::user()->karyawan->avatar }}" alt="Avatar"
                                    style="border: none">
                            </div>

                            <h3 class="profile-username text-center">{{ $guru->karyawan->nama_lengkap }} </h3>

                            <p class="text-muted text-center">Guru</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Username</b> <a class="float-right">{{ $guru->karyawan->user->username }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>NIP</b> <a class="float-right">{{ $guru->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>NUPTK</b> <a class="float-right">{{ $guru->nomor_hp }}</a>
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
                            <form action="{{ route('guru.profile.update', $guru->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Full name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_lengkap"
                                            value="{{ $guru->karyawan->nama_lengkap }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Gelar</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="gelar" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">NIP <small><i>(opsional)</i></small></label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="nip"
                                            value="{{ $guru->nip }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-10 pt-1">
                                        <label class="form-check-label me-3"><input type="radio" name="jenis_kelamin"
                                                value="Male" @if ($guru->jenis_kelamin == 'Male') checked @endif required>
                                            Male</label>
                                        <label class="form-check-label me-3"><input type="radio" name="jenis_kelamin"
                                                value="Female" @if ($guru->jenis_kelamin == 'Female') checked @endif required>
                                            Female</label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="tempat_lahir"
                                            value="{{ $guru->tempat_lahir }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="tanggal_lahir"
                                            value="{{ $guru->tanggal_lahir }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">NUPTK <small><i>(opsional)</i></small></label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="nuptk"
                                            value="{{ $guru->nuptk }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Address </label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="alamat" rows="2">{{ $guru->alamat }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Foto Profile </label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input form-control form-control"
                                                name="avatar" id="customFile" accept="image/*">
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
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <a href="{{ route('gantipassword') }}" class="btn btn-danger">Change Password</a>
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

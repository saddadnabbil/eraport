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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-friends"></i> {{ $title }}</h3>
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Tambah" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-tambah">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                {{-- <div data-bs-toggle="tooltip" title="Export" class="d-inline-block">
                                    <a href="{{ route('user.export') }}" class="btn btn-tool btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div> --}}
                                <div data-bs-toggle="tooltip" title="Trash" class="d-inline-block" class="d-inline-block">
                                    <a href="{{ route('user.trash') }}" class="btn btn-tool btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Modal tambah  -->
                        <div class="modal fade" id="modal-tambah">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah {{ $title }} Admin</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                        </button>
                                    </div>
                                    <form action="{{ route('user.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" placeholder="username" value="{{ old('username') }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-3 col-form-label">Password</label>
                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder="password" value="{{ old('password') }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="role" class="col-sm-3 col-form-label">Role</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select " name="role" id=""
                                                        required>
                                                        <option value="" selected>-- Select Role --</option>
                                                        @foreach ($data_roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="permission" class="col-sm-3 col-form-label">Permission</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select " name="permission[]"
                                                        id="" multiple required>
                                                        @foreach ($data_permission as $permission)
                                                            <option value="{{ $permission->id }}">{{ $permission->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-end">
                                            <button type="button" class="btn btn-default"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal tambah -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Full name</th>
                                            <th>Username</th>
                                            <th>Level</th>
                                            <th>Status Akun</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_user as $user)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>
                                                    @if ($user->role == 3)
                                                        <a class="text-decoration-none text-body"
                                                            href="{{ route('siswa.show', $user->siswa->id) }}">{{ $user->siswa->nama_lengkap }}</a>
                                                    @elseif($user->karyawan)
                                                        <a class="text-decoration-none text-body"
                                                            href="{{ route('karyawan.show', $user->karyawan->id) }}">{{ $user->karyawan->nama_lengkap }}</a>
                                                    @endif
                                                </td>

                                                <td>{{ $user->username }}</td>
                                                <td>
                                                    @if ($user->role == '3')
                                                        Student
                                                    @elseif($user->role == '2')
                                                        Teacher
                                                    @elseif($user->role == '0' || $user->role == '1')
                                                        Administrator
                                                    @else
                                                        Employee
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($user->status == true)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Non Aktif</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $cacheKey = 'delete-button-' . $user->id;
                                                        $deleteButton = Cache::remember($cacheKey, 120, function () use ($user) {
                                                            if ($user->role == '3' && $user->siswa) {
                                                                $showRoute = route('siswa.show', $user->siswa->id);
                                                            } elseif ($user->karyawan) {
                                                                $showRoute = route('karyawan.show', $user->karyawan->id);
                                                            } else {
                                                                $showRoute = '#';
                                                            }

                                                            return view('components.actions.delete-button', [
                                                                'route' => route('user.destroy', $user->id),
                                                                'id' => $user->id,
                                                                'isPermanent' => false,
                                                                'withEdit' => true,
                                                                'withShow' => true,
                                                                'showRoute' => $showRoute,
                                                            ])->render();
                                                        });
                                                    @endphp

                                                    {!! $deleteButton !!}
                                                </td>
                                            </tr>

                                            <!-- Modal edit -->
                                            <div class="modal fade" id="modal-edit{{ $user->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }} Admin</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <form action="{{ route('user.update', $user->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="username"
                                                                        class="col-sm-3 col-form-label">Username</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="username" name="username"
                                                                            placeholder="Username"
                                                                            value="{{ $user->username }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="password"
                                                                        class="col-sm-3 col-form-label">Password</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="password" class="form-control"
                                                                            id="password" name="password"
                                                                            placeholder="Password">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="role"
                                                                        class="col-sm-3 col-form-label">Role</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control form-select "
                                                                            name="role" id="">
                                                                            @foreach ($data_roles as $role)
                                                                                <option value="{{ $role->id }}"
                                                                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                                                    {{ $role->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="permission"
                                                                        class="col-sm-3 col-form-label">Permission</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control form-select"
                                                                            name="permission[]" id="permission" multiple>
                                                                            @foreach ($data_permission as $permission)
                                                                                <option value="{{ $permission->id }}"
                                                                                    {{ $user->hasPermissionTo($permission->name) ? 'selected' : '' }}>
                                                                                    {{ $permission->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="status"
                                                                        class="col-sm-3 col-form-label">Status Akun</label>
                                                                    <div class="col-sm-9 pt-1">
                                                                        <label class="radio-inline me-3"><input
                                                                                type="radio" name="status"
                                                                                value="1"
                                                                                @if ($user->status == 1) checked @endif
                                                                                required> Aktif</label>
                                                                        <label class="radio-inline me-3"><input
                                                                                type="radio" name="status"
                                                                                value="0"
                                                                                @if ($user->status == 0) checked @endif
                                                                                required> Non Aktif</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-end">
                                                                <button type="button" class="btn btn-default"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal edit -->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    </div>
@endsection

@section('footer')
    @include('layouts.main.footer')
@endsection

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
                    'url' => route('admin.dashboard'),
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
            <div class="callout callout-info">
                <h5>Add, edit, and delete {{ $title }}</h5>
                <p>Please go through the Employee menu or click the button below.</p>
                <a href="{{ route('karyawan.index') }}" class="btn btn-primary text-white mt-2" style="text-decoration:none">
                    Employee</a>
                <a href="{{ route('siswa.index') }}" class="btn btn-success text-white mt-2" style="text-decoration:none">
                    Student</a>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-friends"></i> {{ $title }}</h3>
                            <div class="card-tools">
                            </div>
                        </div>

                        <!-- Modal tambah  -->
                        {{-- <div class="modal fade" id="modal-tambah">
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
                                                    <select class="form-control form-select select2" name="role"
                                                        id="" required>
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
                                                    <select class="form-control form-select select2" name="permission[]"
                                                        id="" multiple="multiple" required>
                                                        <option value="">-- Select Permission --</option>
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
                        </div> --}}
                        <!-- End Modal tambah -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Full name</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Permission</th>
                                            <th>Status Akun</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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

@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#zero_config').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('user.data') }}",
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "full_name"
                    },
                    {
                        "data": "username"
                    },
                    {
                        "data": "role"
                    },
                    {
                        "data": "permission"
                    },
                    {
                        "data": "status_akun"
                    },
                    {
                        "data": "action",
                        "orderable": false,
                        "searchable": false
                    }
                ],
                "language": {
                    "processing": "<div class='spinner-border text-primary' role='status'><span class='visually-hidden'>Loading...</span></div>"
                }
            });
        });
    </script>
@endpush

@section('footer')
    @include('layouts.main.footer')
@endsection

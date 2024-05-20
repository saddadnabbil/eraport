@extends('layouts.main.header')

@section('sidebar')
    @include('layouts.sidebar.admin')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            $dashboard = route('admin.dashboard');
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
            <div class="callout callout-info">
                <h5>Add, edit, and delete {{ $title }}</h5>
                <p>Please go through the Employee menu or click the button below.</p>
                <a href="{{ route('karyawan.index') }}" class="btn btn-primary text-white mt-2" style="text-decoration:none">
                    Employee</a>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-success text-white mt-2"
                    style="text-decoration:none">
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

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Full name</th>
                                            <th>Username</th>
                                            <th>Role</th>
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

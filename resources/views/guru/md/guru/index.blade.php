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
                    'url' => route('guru.dashboard'),
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
                <p>Please Contact Admin</p>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Full name</th>
                                            <th>Unit</th>
                                            <th>Employee Code</th>
                                            <th>Identity Card</th>
                                            <th>Number Phone</th>
                                            <th>Gender</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
@endsection

@push('custom-scripts')
    {{-- datatable --}}
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#zero_config')) {
                $('#zero_config').DataTable({
                    "processing": true,
                    "language": {
                        "processing": '<i class="fas fa-spinner fa-spin"></i> Processing...'
                    },
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('guru.guru.data') }}",
                    },
                    "columns": [{
                            "data": "id"
                        },
                        {
                            "data": "full_name"
                        },
                        {
                            "data": "unit_nama"
                        },
                        {
                            "data": "employee_code"
                        },
                        {
                            "data": "identity_card"
                        },
                        {
                            "data": "number_phone"
                        },
                        {
                            "data": "gender"
                        },
                        {
                            "data": "action",
                            "orderable": false,
                            "searchable": false
                        }
                    ]
                });
            }
        });
    </script>
@endpush


@section('footer')
    @include('layouts.main.footer')
@endsection

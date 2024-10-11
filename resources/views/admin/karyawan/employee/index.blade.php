@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.admin')
@endsection

@section('content')
    <div class="page-wrapper" style="background-color: #eaeaeaea">
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
                    'url' => route('karyawan.index'),
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

            {{-- data table --}}
            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                            <div class="card-tools">
                                <div class="d-inline-block">
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-tambah">
                                        <i class="fas fa-plus"></i>
                                        Create
                                    </button>
                                </div>
                                <div class="d-inline-block" class="d-inline-block">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-import">
                                        <i class="fas fa-upload"></i>
                                        Import
                                    </button>
                                </div>
                                <div class="d-inline-block" class="d-inline-block">
                                    <a href="{{ route('karyawan.trash') }}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                        Trash
                                    </a>
                                </div>
                            </div>
                        </div>

                        @include('admin.karyawan.employee.modal.create')
                        @include('admin.karyawan.employee.modal.import')

                        <div class="card-body">
                            <div class="table-responsive">

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
                                        <strong>Failed!</strong> There are errors in the form submission. Please check
                                        again:
                                        <ul style="list-style-type: inside; padding-left: 20px;">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <table id="zero_config_ajax" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Employee Code</th>
                                            <th>Employee Name</th>
                                            <th>Sex</th>
                                            <th>Status Employee</th>
                                            <th>Unit</th>
                                            <th>Position</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
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
        <!--/. container-fluid -->
    </div>
@endsection

@push('custom-scripts')
    {{-- loading button import  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.forms['import-karyawan'].addEventListener('submit', function() {
                // Tampilkan ikon/loading GIF
                document.getElementById('loading').style.display = 'inline-block';

                // Simulasikan proses pengiriman form
                setTimeout(function() {
                    // Sembunyikan ikon/loading GIF
                    document.getElementById('loading').style.display = 'none';
                }, 40000);
            });
        });
    </script>

    <!-- pas_photo preview-->
    <script>
        function readURLTtd(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#ttd_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLPasPhoto(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#pas_photo_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLKartuIdentitas(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#photo_kartu_identitas_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLTaxpayer(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#photo_taxpayer_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLKK(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#photo_kk_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLOtherDocument(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#other_document_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    {{-- datatable --}}
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#zero_config_ajax')) {
                $('#zero_config_ajax').DataTable({
                    "ajax": {
                        "url": "{{ route('karyawan.data') }}",
                    },
                    "columns": [{
                            "data": "id"
                        },
                        {
                            "data": "kode_karyawan"
                        },
                        {
                            "data": "nama_lengkap"
                        },
                        {
                            "data": "jenis_kelamin"
                        },
                        {
                            "data": "status_karyawan.nama_status_karyawan"
                        },
                        {
                            "data": "unit_karyawan.nama_unit_karyawan"
                        },
                        {
                            "data": "position_karyawan.nama_position_karyawan"
                        },
                        {
                            "data": "status"
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

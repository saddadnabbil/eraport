@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.tu')
@endsection

@section('content')
    <div class="page-wrapper" style="background-color: #eaeaeaea">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            $dashboard = route('tu.dashboard');
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
                    'url' => route('guru.tapel.index'),
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
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box" style="position: relative; border-right: 5px solid #5f76e8">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-layer-group  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Playgroup</span>
                            @if (isset($jumlah_kelas_per_level['1']))
                                <span class="info-box-number">{{ $jumlah_kelas_per_level['1'] }}
                                    <small>students</small></span>
                            @else
                                <span class="info-box-number">0 <small>students</small></span>
                            @endif
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3" style="position: relative; border-right: 5px solid #ff4f70">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-book  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Kindergarten A</span>
                            @if (isset($jumlah_kelas_per_level['2']))
                                <span class="info-box-number">{{ $jumlah_kelas_per_level['2'] }}
                                    <small>students</small></span>
                            @else
                                <span class="info-box-number">0 <small>students</small></span>
                            @endif
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3" style="position: relative; border-right: 5px solid #ff4f70">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-book  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Kindergarten B</span>
                            @if (isset($jumlah_kelas_per_level['3']))
                                <span class="info-box-number">{{ $jumlah_kelas_per_level['3'] }}
                                    <small>students</small></span>
                            @else
                                <span class="info-box-number">0 <small>students</small></span>
                            @endif
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3" style="position: relative; border-right: 5px solid #22ca80">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Primary School</span>
                            @if (isset($jumlah_kelas_per_level['4']))
                                <span class="info-box-number">{{ $jumlah_kelas_per_level['4'] }}
                                    <small>students</small></span>
                            @else
                                <span class="info-box-number">0 <small>students</small></span>
                            @endif
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3" style="position: relative; border-right: 5px solid #fdc16a">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fas fa-book-reader text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Junior High School</span>
                            @if (isset($jumlah_kelas_per_level['5']))
                                <span class="info-box-number">{{ $jumlah_kelas_per_level['5'] }}
                                    <small>students</small></span>
                            @else
                                <span class="info-box-number">0 <small>students</small></span>
                            @endif
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3" style="position: relative; border-right: 5px solid #fdc16a">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fas fa-book-reader  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Senior High School</span>
                            @if (isset($jumlah_kelas_per_level['6']))
                                <span class="info-box-number">{{ $jumlah_kelas_per_level['6'] }}
                                    <small>students</small></span>
                            @else
                                <span class="info-box-number">0 <small>students</small></span>
                            @endif
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> {{ $title }}</h3>
                            <div class="card-tools">
                                <div class="d-inline-block" class="d-inline-block">
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
                                    <a href="{{ route('tu.siswa.export') }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-download"></i>
                                        Export
                                    </a>
                                </div>
                                <div class="d-inline-block" class="d-inline-block">
                                    <a href="{{ route('tu.siswa.trash') }}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                        Trash
                                    </a>
                                </div>
                            </div>
                        </div>

                        @include('tu.siswa.modal.import')
                        @include('tu.siswa.modal.create')

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
                                            <th>Name</th>
                                            <th>Level</th>
                                            <th>Class</th>
                                            <th>NIS</th>
                                            <th>NISN</th>
                                            <th>Sex</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
    {{-- loading button import  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.forms['import-siswa'].addEventListener('submit', function() {
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
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#pas_photo_preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <!-- ajax get class id and and jurusan class name-->
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="tingkatan_id"]').on('change', function() {
                var tingkatan_id = $(this).val();
                console.log(tingkatan_id);
                if (tingkatan_id) {
                    $.ajax({
                        url: '/getKelasByTingkatan/ajax/' + tingkatan_id,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('select[name="kelas_id"]').empty();
                            $('select[name="jurusan_id"]').empty();

                            $('select[name="kelas_id"]').append(
                                '<option value="">-- Select Class Name --</option>'
                            );

                            $('select[name="jurusan_id"]').append(
                                '<option value="">-- Select Level Name --</option>'
                            );

                            $.each(response.data, function(i, item) {
                                $('select[name="kelas_id"]').append(
                                    '<option value="' +
                                    item.id + '">' + item.nama_kelas + '</option>');
                            });

                            $.each(response.data_jurusan, function(i, item) {
                                $('select[name="jurusan_id"]').append(
                                    '<option value="' +
                                    item.id + '">' + item.nama_jurusan + '</option>'
                                );
                            });
                        }
                    });
                } else {
                    $('select[name="kelas_id"').empty();
                }
            });
        });
    </script> --}}

    {{-- datatable --}}
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#zero_config_ajax')) {
                $('#zero_config_ajax').DataTable({
                    "ajax": {
                        "url": "{{ route('tu.siswa.data') }}",
                    },
                    "columns": [{
                            "data": "id"
                        },
                        {
                            "data": "nama_lengkap"
                        },
                        {
                            "data": "tingkatan"
                        },
                        {
                            "data": "kelas"
                        },
                        {
                            "data": "nis"
                        },
                        {
                            "data": "nisn"
                        },
                        {
                            "data": "jenis_kelamin"
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

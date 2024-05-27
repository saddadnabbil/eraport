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
                    <div class="info-box">
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
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-book  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Kindergarten</span>
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

                <!-- fix for small devices only -->
                {{-- <div class="clearfix hidden-md-up"></div> --}}

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Primary School</span>
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
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fas fa-book-reader text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Junior High School</span>
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
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fas fa-book-reader  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Senior High School</span>
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
            </div>
            <!-- /.row -->

            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> {{ $title }}</h3>
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Create" class="d-inline-block" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-tambah">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div data-bs-toggle="tooltip" title="Import" class="d-inline-block" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-import">
                                        <i class="fas fa-upload"></i>
                                    </button>
                                </div>
                                <div data-bs-toggle="tooltip" title="Export" class="d-inline-block" class="d-inline-block">
                                    <a href="{{ route('guru.siswa.export') }}" class="btn btn-tool btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                <div data-bs-toggle="tooltip" title="Trash" class="d-inline-block" class="d-inline-block">
                                    <a href="{{ route('guru.siswa.trash') }}" class="btn btn-tool btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        @include('guru.md.siswa.modal.import')
                        @include('guru.md.siswa.modal.create')

                        <div class="card-body">
                            <div class="table-responsive">
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
                                            <th>Action</th>
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
    <script type="text/javascript">
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
    </script>

    {{-- datatable --}}
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#zero_config_ajax')) {
                $('#zero_config_ajax').DataTable({
                    "ajax": {
                        "url": "{{ route('guru.siswa.data') }}",
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

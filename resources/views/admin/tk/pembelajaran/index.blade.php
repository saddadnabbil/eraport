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
            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-book-open"></i> {{ $title }}</h3>
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Setting" class="d-inline-block" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-settings">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                </div>
                                {{-- <div data-bs-toggle="tooltip" title="Export" class="d-inline-block" class="d-inline-block">
                                    <a href="{{ route('tkpembelajaran.export') }}" class="btn btn-tool btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Modal settings  -->
                        <div class="modal fade" id="modal-settings">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Setting Pembelajaran</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label for="tingkatan_id" class="col-sm-2 col-form-label">Tingkatan</label>
                                            <div class="col-sm-10">
                                                <form action="{{ route('tkpembelajaran.settings') }}" method="POST">
                                                    @csrf
                                                    <select class="form-control form-select select2" name="tingkatan_id"
                                                        style="width: 100%;" required onchange="this.form.submit();">
                                                        <option value="">-- Pilih Tingkatan --</option>
                                                        @foreach ($data_tingkatan as $tingkatan)
                                                            <option value="{{ $tingkatan->id }}">
                                                                {{ $tingkatan->nama_tingkatan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal settings -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Semester</th>
                                            <th>Tingkatan</th>
                                            <th>Topic</th>
                                            <th>Guru</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_pembelajaran as $pembelajaran)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $pembelajaran->tingkatan->tahun_pelajaran }}
                                                    @if ($pembelajaran->tingkatan->semester_id == 1)
                                                        Ganjil
                                                    @else
                                                        Genap
                                                    @endif
                                                </td>
                                                <td>{{ $pembelajaran->tingkatan->nama_tingkatan }}</td>
                                                <td>{{ $pembelajaran->topic->name }}</td>
                                                <td>
                                                    @if ($pembelajaran->guru)
                                                        {{ $pembelajaran->guru->karyawan->nama_lengkap }}
                                                        {{ $pembelajaran->guru->gelar }}
                                                    @else
                                                        Guru not available
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
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

@section('footer')
    @include('layouts.main.footer')
@endsection

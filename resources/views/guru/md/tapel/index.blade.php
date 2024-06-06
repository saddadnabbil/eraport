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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Setting Of The School Year</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('guru.tapel.setAcademicYear') }}" method="POST">
                                @csrf
                                <div class="form-group row border-bottom">
                                    <div class="col-lg-5 col-md-6 form-inline" style="margin-bottom: 14px">
                                        <label class="col-lg-6 col-md-6font-weight-normal" for="select_tapel_id">Academic
                                            Year</label>
                                        <div class="col-6">
                                            <select class="custom-select form-control" name="select_tapel_id">
                                                {{-- <option selected>{{ $tapel_id }}</option> --}}
                                                @foreach ($data_tapel as $tapel)
                                                    <option value="{{ $tapel->id }}"
                                                        @if ($tapel->id == $tapel_id) selected @endif>
                                                        {{ $tapel->tahun_pelajaran }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @foreach ($data_tingkatan as $tingkatan)
                                    @php
                                        if ($tingkatan->id == '2' || $tingkatan->id == '3') {
                                            continue;
                                        }
                                    @endphp
                                    <div class="level border-bottom mt-1">
                                        <div>
                                            <p class="">
                                                <b>{{ $tingkatan->nama_tingkatan == 'Playgroup' ? 'Playgroup & Kindergarten' : $tingkatan->nama_tingkatan }}</b>
                                            </p>
                                        </div>

                                        <div class="form-group row ">
                                            @if ($tingkatan->nama_tingkatan == 'Playgroup')
                                                <div class="col-lg-5 col-md-6 form-inline">
                                                    <label class="col-lg-6 col-md-6 font-weight-normal"
                                                        for="select_term_id">Term</label>
                                                    <div class="col-6">
                                                        <select class="custom-select form-control"
                                                            name="select_term_{{ str_replace(' ', '', strtolower($tingkatan->nama_tingkatan)) }}_id">
                                                            @foreach ($data_term as $term)
                                                                <option value="{{ $term->id }}"
                                                                    @if ($term->id == $tingkatan->term_id) selected @endif>
                                                                    {{ $term->term }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    <div class="col-lg-5 col-md-6 form-inline">
                                                        <label class="col-lg-6 col-md-6 font-weight-normal"
                                                            for="select_semester_{{ str_replace(' ', '', strtolower($tingkatan->nama_tingkatan)) }}_id">Semester</label>
                                                        <div class="col-6">
                                                            <select class="custom-select form-control  me-3"
                                                                name="select_semester_{{ str_replace(' ', '', strtolower($tingkatan->nama_tingkatan)) }}_id">
                                                                @foreach ($data_semester as $semester)
                                                                    <option value="{{ $semester->id }}"
                                                                        @if ($semester->id == $tingkatan->semester_id) selected @endif>
                                                                        {{ $semester->semester }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-5 col-md-6 form-inline">
                                                        <label class="col-lg-6 col-md-6 font-weight-normal"
                                                            for="select_term_id">Term</label>
                                                        <div class="col-6">
                                                            <select class="custom-select form-control"
                                                                name="select_term_{{ str_replace(' ', '', strtolower($tingkatan->nama_tingkatan)) }}_id">
                                                                @foreach ($data_term as $term)
                                                                    @if ($term->id == 1 || $term->id == 2)
                                                                        <option value="{{ $term->id }}"
                                                                            @if ($term->id == $tingkatan->term_id) selected @endif>
                                                                            {{ $term->term }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                            @endif


                                        </div>
                                    </div>
                        </div>
                        @endforeach

                        <div class="d-flex
                                                justify-content-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- data table --}}
        <!-- ./row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>
                        <div class="card-tools">
                            <div data-bs-toggle="tooltip" title="Create" class="d-inline-block">
                                <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modal-tambah">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal tambah  -->
                    <div class="modal fade" id="modal-tambah">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah {{ $title }}</h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-hidden="true"></button>
                                    </button>
                                </div>
                                <form action="{{ route('guru.tapel.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label for="tahun_pelajaran" class="col-sm-3 col-form-label">Tahun
                                                Pelajaran</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="tahun_pelajaran"
                                                    name="tahun_pelajaran" placeholder="Academic Year"
                                                    value="{{ old('tahun_pelajaran') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-default"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal tambah -->

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-valign-middle ">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Academic Year</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    @foreach ($data_tapel as $tapel)
                                        <?php $no++; ?>
                                        <tr style="{{ $tapel->id == $tapel_id ? 'background-color:#d9edf7;' : '' }}">
                                            <td>{{ $no }}</td>
                                            <td>{{ $tapel->tahun_pelajaran }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-warning btn-sm mt-1"
                                                    data-bs-toggle="modal" data-bs-target="#modal-edit{{ $tapel->id }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal edit  -->
                                        <div class="modal fade" id="modal-edit{{ $tapel->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit {{ $title }}</h5>

                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-hidden="true"></button>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route('guru.tapel.update', $tapel->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group row">
                                                                <label for="tahun_pelajaran"
                                                                    class="col-sm-3 col-form-label">Tahun
                                                                    Pelajaran</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="tahun_pelajaran" name="tahun_pelajaran"
                                                                        placeholder="Academic Year"
                                                                        value="{{ $tapel->tahun_pelajaran }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-end">
                                                            <button type="button" class="btn btn-default"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
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

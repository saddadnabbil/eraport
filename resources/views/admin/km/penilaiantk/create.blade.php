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
                    'title' => 'Penilaian TK',
                    'url' => route('penilaiantk.index'),
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => '',
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
                            <h3 class="card-title"><i class="fas fa-list-ol"></i> {{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="callout callout-info">
                                <form action="{{ route('penilaiantk.create') }}" method="GET">
                                    @csrf
                                    {{-- <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Term</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{ $term->term }}" disabled>
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Kelas</label>
                                        <div class="col-sm-10">
                                            <select class="form-control form-select select2" name="kelas_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="" disabled>-- Pilih Kelas --</option>
                                                @foreach ($data_kelas as $kelas_item)
                                                    <option value="{{ $kelas_item->id }}"
                                                        @if ($kelas_item->id == $kelas->id) selected @endif>
                                                        {{ $kelas_item->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="d-md-block d-lg-flex">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="table-responsive p-2 w-md-100">
                                        @csrf
                                        <table class="table table-bordered">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th style="width: 10%"">No</th>
                                                    <th style="width: 80%" class="d-md-table-cell">Name</th>
                                                    <th style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data_anggota_kelas as $anggota_kelas)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $anggota_kelas->siswa->nama_lengkap }}</td>
                                                        <td class="text-center">
                                                            <form action="{{ route('penilaiantk.show') }}" method="post">
                                                            </form>
                                                            <a href="{{ route('penilaiantk.show', $anggota_kelas->id) }}"
                                                                class="btn btn-primary btn-sm"><i
                                                                    class="fas fa-search"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

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
@endpush

@section('footer')
    @include('layouts.main.footer')
@endsection

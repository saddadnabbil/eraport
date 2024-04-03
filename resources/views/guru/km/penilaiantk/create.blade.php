@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.guru')
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
                    'url' => route('guru.penilaiantk.index'),
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
                                <form action="{{ route('guru.penilaiantk.create') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="term_id" class="col-sm-2 col-form-label">Term</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select select2" name="term_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="">-- Pilih Term --</option>
                                                @foreach ($data_term as $term_item)
                                                    <option value="{{ $term_item->id }}"
                                                        @if ($term_item->id == $term->id) selected @endif>
                                                        {{ $term_item->term }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Kelas</label>
                                        <div class="col-sm-4">
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
                                                @if ($data_anggota_kelas->count() == 0)
                                                    <tr>
                                                        <td colspan="3" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                @else
                                                    @foreach ($data_anggota_kelas as $anggota_kelas)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $anggota_kelas->siswa->nama_lengkap }}</td>
                                                            <td class="text-center">
                                                                <form
                                                                    action="{{ route('guru.penilaiantk.show', $anggota_kelas->siswa_id) }}"
                                                                    method="get">
                                                                    @csrf
                                                                    <input type="hidden" name="kelas_id"
                                                                        value="{{ $kelas->id }}">
                                                                    <input type="hidden" name="term_id"
                                                                        value="{{ $term->id }}">
                                                                    <input type="hidden" name="anggota_kelas_id"
                                                                        value="{{ $anggota_kelas->id }}">
                                                                    <input type="hidden" name="term_id"
                                                                        value="{{ $term->id }}">

                                                                    <button class="btn btn-primary btn-sm" type="submit">
                                                                        <i class="fas fa-search"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
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

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
                    'title' => 'Rencana Formatif',
                    'url' => route('rencanaformatif.index'),
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
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="callout callout-info">
                                <form action="{{ route('rencanaformatif.create') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="pembelajaran_id" class="col-sm-2 col-form-label">Mata Pelajaran</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="pembelajaran_id" value="{{ $pembelajaran->id }}">
                                            <input type="text" class="form-control"
                                                value="{{ $pembelajaran->mapel->nama_mapel }} {{ $pembelajaran->kelas->nama_kelas }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jumlah_penilaian" class="col-sm-2 col-form-label">Jumlah
                                            Penilaian</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control " name="jumlah_penilaian"
                                                id="jumlah_penilaian" value="{{ $jumlah_penilaian }}" style="width: 100%;"
                                                required onchange="this.form.submit();" disabled>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <form action="{{ route('rencanaformatif.store') }}" method="POST">
                                @csrf

                                <input type="hidden" name="pembelajaran_id" value="{{ $pembelajaran->id }}">
                                <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                                <input type="hidden" name="term_id" value="{{ $term->term }}">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>Penilaian</th>
                                                @for ($i = 1; $i <= $jumlah_penilaian; $i++)
                                                    <th class="text-center">P.{{ $i }}</th>
                                                @endfor
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-primary">
                                                <td>Kelompok/Teknik Penilaian</td>
                                                @for ($i = 1; $i <= $jumlah_penilaian; $i++)
                                                    <td>
                                                        <select class="form-control form-select" name="teknik_penilaian[]"
                                                            style="width: 100%;" required
                                                            oninvalid="this.setCustomValidity('silakan pilih item dalam daftar')"
                                                            oninput="setCustomValidity('')">
                                                            <option value="">-- Teknik Penilaian --</option>
                                                            <option value="1"
                                                                @if ($i == 1) selected @endif>Praktik
                                                            </option>
                                                            <option value="2"
                                                                @if ($i == 2) selected @endif>Projek
                                                            </option>
                                                            <option value="3"
                                                                @if ($i == 3) selected @endif>Produk
                                                            </option>
                                                            <option value="4"
                                                                @if ($i == 4) selected @endif>Teknik 1
                                                            </option>
                                                            <option value="5"
                                                                @if ($i == 5) selected @endif>Teknik 2
                                                            </option>
                                                        </select>
                                                    </td>
                                                @endfor
                                            </tr>
                                            <tr class="bg-primary">
                                                <td>Kode Penilaian</td>
                                                @for ($i = 1; $i <= $jumlah_penilaian; $i++)
                                                    <td>
                                                        <input type="text" class="form-control" name="kode_penilaian[]"
                                                            value="F{{ $i }}" required
                                                            oninvalid="this.setCustomValidity('data tidak boleh kosong')"
                                                            oninput="setCustomValidity('')">
                                                    </td>
                                                @endfor
                                            </tr>
                                            <tr class="bg-primary">
                                                <td>Bobot Teknik Penilaian</td>
                                                @for ($i = 1; $i <= $jumlah_penilaian; $i++)
                                                    <td>
                                                        <input type="number" class="form-control"
                                                            name="bobot_teknik_penilaian[]" value="{{ $i == 1 ? 40 : 30 }}"
                                                            required
                                                            oninvalid="this.setCustomValidity('data tidak boleh kosong')"
                                                            oninput="setCustomValidity('')">
                                                    </td>
                                                @endfor
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                        </div>

                        <div class="card-footer clearfix">
                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                            <a href="{{ route('rencanaformatif.index') }}"
                                class="btn btn-default float-right me-2">Batal</a>
                        </div>
                        </form>
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

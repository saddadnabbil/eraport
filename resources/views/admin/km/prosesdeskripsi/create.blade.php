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
                    'title' => 'Deskripsi Nilai Siswa',
                    'url' => route('km.prosesdeskripsi.index'),
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
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-info">
                                <form action="{{ route('km.prosesdeskripsi.create') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Semester</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="{{ $semester->id }}" disabled>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Term</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="{{ $term->term }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Subject</label>
                                        <div class="col-sm-10">
                                            <select class="form-control form-select select2" name="pembelajaran_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="" disabled>-- Select Learning Data --</option>
                                                @foreach ($data_pembelajaran as $mapel)
                                                    <option value="{{ $mapel->id }}"
                                                        @if ($mapel->id == $pembelajaran->id) selected @endif>
                                                        {{ $mapel->mapel->nama_mapel }} {{ $mapel->kelas->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <!-- Nilai -->

                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title">Deskripsi Nilai Siswa</h3>
                                </div>
                                <form action="{{ route('km.prosesdeskripsi.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="term_id" value="{{ $term->id }}">
                                    <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="bg-info">
                                                    <tr>
                                                        <th rowspan="2" class="text-center"
                                                            style="width: 75px; vertical-align: middle">No</th>
                                                        <th rowspan="2" class="text-center"
                                                            style="vertical-align: middle">Student Name</th>
                                                        <th class="text-center">Sumatif Grade</th>
                                                        <th class="text-center">Formatif Grade</th>
                                                        <th class="text-center align-middle">Capaian Pembelajaran</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center" style="width: 50px;">Nilai</th>
                                                        <th class="text-center" style="width: 50px;">Nilai</th>
                                                        <th class="text-center">Deskripsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <input type="hidden" name="pembelajaran_id"
                                                        value="{{ $pembelajaran->id }}">

                                                    <?php $no = 0; ?>
                                                    @forelse($data_nilai_siswa->sortBy('anggota_kelas.siswa.nama_lengkap') as $nilai_siswa)
                                                        <?php $no++; ?>
                                                        <input type="hidden" name="nilai_akhir_raport_id[]"
                                                            value="{{ $nilai_siswa->id }}">
                                                        <tr>
                                                            <td class="text-center">{{ $no }}</td>
                                                            <td>{{ $nilai_siswa->anggota_kelas->siswa->nama_lengkap }}</td>

                                                            <td class="text-center">{{ $nilai_siswa->nilai_formatif }}</td>


                                                            <td class="text-center">{{ $nilai_siswa->nilai_sumatif }}</td>
                                                            <td>
                                                                <textarea class="form-control" name="deskripsi_raport[]" rows="4" minlength="30" maxlength="200"
                                                                    oninvalid="this.setCustomValidity('Deskripsi harus berisi antara 30 s/d 200 karekter')"
                                                                    oninput="setCustomValidity('')">{{ !is_null($nilai_siswa->deskripsi_nilai_siswa) ? $nilai_siswa->deskripsi_nilai_siswa->deskripsi_raport ?? '' : '' }}</textarea>
                                                            </td>

                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center">Data not available</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer clearfix">
                                        <button type="submit" class="btn btn-primary float-right">Simpan</button>
                                        <a href="{{ route('km.prosesdeskripsi.index') }}"
                                            class="btn btn-default float-right me-2">Batal</a>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div> <!-- /.card -->
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

</body>

</html>

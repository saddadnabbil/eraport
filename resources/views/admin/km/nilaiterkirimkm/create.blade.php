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
                    'title' => 'Submitted Grades',
                    'url' => route('km.nilaiterkirim.index'),
                    'active' => false,
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
                            <h3 class="card-title"><i class="fas fa-eye"></i> {{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="callout callout-info">
                                <form action="{{ route('km.nilaiterkirim.create') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Semester</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select select2" name="semester_id"
                                                style="width: 100%;" disabled>
                                                <option value="{{ $semester->id }}" selected>{{ $semester->semester }}
                                                </option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Term</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select select2" name="term"
                                                style="width: 100%;" disabled>
                                                <option value="{{ $term->id }}" selected>{{ $term->term }}</option>
                                            </select>
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
                                <div class="card-header bg-success">
                                    <h3 class="card-title"> Nilai Raport Terkirim</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="bg-info">
                                                <tr>
                                                    <th rowspan="2" class="text-center" style="vertical-align: middle">No
                                                    </th>
                                                    <th rowspan="2" class="text-center" style="vertical-align: middle">
                                                        Student Name</th>
                                                    <th rowspan="2" class="text-center" style="vertical-align: middle">
                                                        KKM</th>
                                                    <th colspan="2" class="text-center">Sumatif</th>
                                                    <th colspan="2" class="text-center">Formatif</th>
                                                    <th colspan="2" class="text-center">Akhir</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">Nilai</th>
                                                    <th class="text-center">Predikat</th>
                                                    <th class="text-center">Nilai</th>
                                                    <th class="text-center">Predikat</th>
                                                    <th class="text-center">Nilai</th>
                                                    <th class="text-center">Predikat</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 0; ?>
                                                @forelse ($data_nilai_terkirim ? $data_nilai_terkirim->sortBy('anggota_kelas.siswa.nama_lengkap') : [] as $nilai_terkirim)
                                                    <?php $no++; ?>
                                                    <tr>
                                                        <td class="text-center" style="width: 100px;">
                                                            {{ $no }}</td>

                                                        <td>
                                                            @if ($nilai_terkirim && $nilai_terkirim->anggota_kelas && $nilai_terkirim->anggota_kelas->siswa)
                                                                {{ $nilai_terkirim->anggota_kelas->siswa->nama_lengkap }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center">{{ $nilai_terkirim->kkm }}</td>

                                                        <td class="text-center">{{ $nilai_terkirim->nilai_sumatif }}
                                                        </td>
                                                        <td class="text-center">{{ $nilai_terkirim->predikat_sumatif }}
                                                        </td>
                                                        <td class="text-center">{{ $nilai_terkirim->nilai_formatif }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $nilai_terkirim->predikat_formatif }}</td>

                                                        <td class="text-center">
                                                            {{ $nilai_terkirim->nilai_akhir_raport }}</td>
                                                        <td class="text-center">
                                                            {{ $nilai_terkirim->predikat_akhir_raport }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center">Data not available
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

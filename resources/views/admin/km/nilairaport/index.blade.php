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
                    'title' => 'Nilai Raport Semester',
                    'url' => route('nilairaportkm.index'),
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
                            <h3 class="card-title"><i class="fas fa-clipboard-check"></i> {{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="callout callout-info">
                                <form action="{{ route('nilairaportkm.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Kelas</label>
                                        <div class="col-sm-10">
                                            <select class="form-control form-select select2" name="pembelajaran_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="" disabled>-- Pilih Kelas --</option>
                                                @foreach ($data_pembelajaran as $pembelajaran)
                                                    <option value="{{ $pembelajaran->id }}"
                                                        @if ($pembelajaran->id == $pembelajaran_id) selected @endif>
                                                        {{ $pembelajaran->mapel->nama_mapel }}
                                                        ({{ $pembelajaran->kelas->nama_kelas }} -
                                                        {{ $pembelajaran->kelas->tingkatan->nama_tingkatan }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="bg-info">
                                        <tr>
                                            <th class="text-center" rowspan="2"
                                                style="width: 5%; vertical-align: middle">No</th>
                                            <th class="text-center" rowspan="2"
                                                style="width: 5%; vertical-align: middle">NIS</th>
                                            <th class="text-center" rowspan="2"
                                                style="width: 37%; vertical-align: middle">Nama Siswa</th>
                                            <th class="text-center" rowspan="2"
                                                style="width: 5%; vertical-align: middle">KKM</th>
                                            <th class="text-center" colspan="2" style="width: 12%;">Sumatif</th>
                                            <th class="text-center" colspan="2" style="width: 12%;">Formatif</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Predikat</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Predikat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_anggota_kelas->sortBy('siswa.nama_lengkap') as $anggota_kelas)
                                            <?php $no++; ?>
                                            @if (!is_null($anggota_kelas->nilai_raport))
                                                <tr>
                                                    <td class="text-center">{{ $no }}</td>
                                                    <td class="text-center">{{ $anggota_kelas->siswa->nis }}</td>
                                                    <td>{{ $anggota_kelas->siswa->nama_lengkap }}</td>
                                                    <td class="text-center">{{ $anggota_kelas->nilai_raport->kkm }}</td>
                                                    <td class="text-center">
                                                        {{ $anggota_kelas->nilai_raport->nilai_sumatif }}</td>
                                                    <td class="text-center">
                                                        {{ $anggota_kelas->nilai_raport->predikat_sumatif }}</td>
                                                    <td class="text-center">
                                                        {{ $anggota_kelas->nilai_raport->nilai_formatif }}</td>
                                                    <td class="text-center">
                                                        {{ $anggota_kelas->nilai_raport->predikat_formatif }}</td>

                                                </tr>
                                            @else
                                                <tr>
                                                    <td class="text-center" colspan="8">Data tidak tersedia.</td>
                                                </tr>
                                            @endif
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

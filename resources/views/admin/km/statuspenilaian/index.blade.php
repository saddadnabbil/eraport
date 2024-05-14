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
                    'title' => 'Status Penilaian',
                    'url' => route('raportstatuskm.penilaian.index'),
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
                            <h3 class="card-title"><i class="fas fa-check-circle"></i> {{ $title }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-info">
                                <form action="{{ route('raportstatuskm.penilaian.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Kelas</label>
                                        <div class="col-sm-10">
                                            <select class="form-control form-select select2" name="kelas_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="" disabled>-- Pilih Kelas --</option>
                                                @foreach ($data_kelas->sortBy('tingkatan_id') as $kls)
                                                    <option value="{{ $kls->id }}"
                                                        @if ($kelas->id == $kls->id) selected @endif>
                                                        {{ $kls->nama_kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="bg-info">
                                        <tr>
                                            <th rowspan="2" class="text-center">No</th>
                                            <th rowspan="2" class="text-center">Mata Pelajaran</th>
                                            <th rowspan="2" class="text-center">Nama Guru</th>
                                            <th colspan="2" class="text-center" style="width: 200px;">Status Perencanaan
                                            </th>
                                            <th colspan="2" class="text-center" style="width: 200px;">Status Penilaian
                                            </th>
                                            <th colspan="2" class="text-center" style="width: 100px;">Status Nilai Raport
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" style="width: 50px;">Sumatif</th>
                                            <th class="text-center" style="width: 50px;">Formatif</th>
                                            <th class="text-center" style="width: 50px;">Sumatif</th>
                                            <th class="text-center" style="width: 50px;">Formatif</th>
                                            <th class="text-center" style="width: 50px;">Kirim Nilai</th>
                                            <th class="text-center" style="width: 50px;">Proses Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_pembelajaran_kelas as $pembelajaran)
                                            <?php $no++; ?>
                                            <tr>
                                                <td class="text-center">{{ $no }}</td>
                                                <td>{{ $pembelajaran->mapel->nama_mapel }}</td>
                                                <td>
                                                    @if ($pembelajaran->guru)
                                                        {{ $pembelajaran->guru->karyawan->nama_lengkap }}
                                                    @else
                                                        Guru not available
                                                    @endif
                                                </td>

                                                @if ($pembelajaran->rencana_pengetahuan == 0)
                                                    <td class="text-center bg-danger"><i class="fas fa-times"></i></td>
                                                @else
                                                    <td class="text-center bg-success"><i class="fas fa-check"></i></td>
                                                @endif

                                                @if ($pembelajaran->rencana_keterampilan == 0)
                                                    <td class="text-center bg-danger"><i class="fas fa-times"></i></td>
                                                @else
                                                    <td class="text-center bg-success"><i class="fas fa-check"></i></td>
                                                @endif

                                                @if ($pembelajaran->nilai_pengetahuan == 0)
                                                    <td class="text-center bg-danger"><i class="fas fa-times"></i></td>
                                                @else
                                                    <td class="text-center bg-success"><i class="fas fa-check"></i></td>
                                                @endif

                                                @if ($pembelajaran->nilai_keterampilan == 0)
                                                    <td class="text-center bg-danger"><i class="fas fa-times"></i></td>
                                                @else
                                                    <td class="text-center bg-success"><i class="fas fa-check"></i></td>
                                                @endif

                                                @if ($pembelajaran->nilai_akhir == 0)
                                                    <td class="text-center bg-danger"><i class="fas fa-times"></i></td>
                                                @else
                                                    <td class="text-center bg-success"><i class="fas fa-check"></i></td>
                                                @endif

                                                @if ($pembelajaran->deskripsi == 0)
                                                    <td class="text-center bg-danger"><i class="fas fa-times"></i></td>
                                                @else
                                                    <td class="text-center bg-success"><i class="fas fa-check"></i></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
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

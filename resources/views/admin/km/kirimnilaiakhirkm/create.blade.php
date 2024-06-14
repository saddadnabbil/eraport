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
                    'title' => 'Submit Final Grade',
                    'url' => route('km.kirimnilaiakhir.index'),
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
                                <form action="{{ route('km.kirimnilaiakhir.create') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Semester</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select select2" name="semester_id"
                                                style="width: 100%;" disabled>
                                                <option value="{{ $semester->id }}" selected>{{ $semester->id }}</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Term</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select select2" name="term_id"
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

                            <!-- Interval KKM -->
                            <div class="card">
                                <div class="card-header bg-success">
                                    <h3 class="card-title"><i class="fas fa-greater-than-equal"></i> Interval Predikat
                                        Berdasarkan KKM</h3>

                                    <div class="card-tools">

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="bg-info">
                                                <tr>
                                                    <th rowspan="2" class="text-center" style="vertical-align: middle">
                                                        KKM</th>
                                                    <th colspan="4" class="text-center">Predikat</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">D = Need Improvement </th>
                                                    <th class="text-center">C = Fair </th>
                                                    <th class="text-center">B = Good </th>
                                                    <th class="text-center">A = Excellent </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">{{ $kkm->kkm }}</td>
                                                    <td class="text-center">
                                                        < {{ $kkm->predikat_d }} </td>
                                                    <td class="text-center">
                                                        {{ $kkm->predikat_d }} <= nilai < {{ $kkm->predikat_c }} </td>
                                                    <td class="text-center">
                                                        {{ $kkm->predikat_c }} <= nilai < {{ $kkm->predikat_b }} </td>
                                                    <td class="text-center">
                                                        {{ $kkm->predikat_b }} <= nilai <={{ $kkm->predikat_a }} </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Nilai -->
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title"> Nilai Raport</h3>
                                </div>
                                <form action="{{ route('km.kirimnilaiakhir.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="term_id" value="{{ $term->id }}">
                                    <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="bg-info">
                                                    <tr>
                                                        <th rowspan="2" class="text-center"
                                                            style="vertical-align: middle">No</th>
                                                        <th rowspan="2" class="text-center"
                                                            style="vertical-align: middle">Student Name</th>
                                                        <th rowspan="2" class="text-center"
                                                            style="vertical-align: middle">KKM</th>
                                                        <th colspan="2" class="text-center">Formatif</th>
                                                        <th colspan="2" class="text-center">Sumatif</th>
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
                                                    <input type="hidden" name="pembelajaran_id"
                                                        value="{{ $pembelajaran->id }}">
                                                    <input type="hidden" name="kkm" value="{{ $kkm->kkm }}">

                                                    <?php $no = 0; ?>
                                                    @forelse ($data_anggota_kelas ? $data_anggota_kelas->sortBy('siswa.nama_lengkap') : [] as $anggota_kelas)
                                                        <?php $no++; ?>
                                                        <tr>
                                                            <td class="text-center" style="width: 100px;">
                                                                {{ $no }}</td>

                                                            <td>{{ $anggota_kelas->siswa->nama_lengkap }}</td>
                                                            <input type="hidden" name="anggota_kelas_id[]"
                                                                value="{{ $anggota_kelas->id }}">

                                                            <td class="text-center">{{ $kkm->kkm }}</td>

                                                            <td class="text-center">
                                                                {{ $anggota_kelas->nilai_keterampilan }}</td>
                                                            <input type="hidden" name="nilai_keterampilan[]"
                                                                value="{{ $anggota_kelas->nilai_keterampilan }}">

                                                            <td class="text-center">
                                                                @if ($anggota_kelas->nilai_keterampilan < $kkm->predikat_d)
                                                                    D
                                                                    <input type="hidden" name="predikat_keterampilan[]"
                                                                        value="D">
                                                                @elseif($anggota_kelas->nilai_keterampilan >= $kkm->predikat_d && $anggota_kelas->nilai_keterampilan < $kkm->predikat_c)
                                                                    C
                                                                    <input type="hidden" name="predikat_keterampilan[]"
                                                                        value="C">
                                                                @elseif($anggota_kelas->nilai_keterampilan >= $kkm->predikat_c && $anggota_kelas->nilai_keterampilan < $kkm->predikat_b)
                                                                    B
                                                                    <input type="hidden" name="predikat_keterampilan[]"
                                                                        value="B">
                                                                @elseif($anggota_kelas->nilai_keterampilan >= $kkm->predikat_b && $anggota_kelas->nilai_keterampilan <= $kkm->predikat_a)
                                                                    A
                                                                    <input type="hidden" name="predikat_keterampilan[]"
                                                                        value="A">
                                                                @endif
                                                            </td>

                                                            <td class="text-center">
                                                                {{ $anggota_kelas->nilai_pengetahuan }}</td>
                                                            <input type="hidden" name="nilai_pengetahuan[]"
                                                                value="{{ $anggota_kelas->nilai_pengetahuan }}">

                                                            <td class="text-center">
                                                                @if ($anggota_kelas->nilai_pengetahuan < $kkm->predikat_d)
                                                                    D
                                                                    <input type="hidden" name="predikat_pengetahuan[]"
                                                                        value="D">
                                                                @elseif($anggota_kelas->nilai_pengetahuan >= $kkm->predikat_d && $anggota_kelas->nilai_pengetahuan < $kkm->predikat_c)
                                                                    C
                                                                    <input type="hidden" name="predikat_pengetahuan[]"
                                                                        value="C">
                                                                @elseif($anggota_kelas->nilai_pengetahuan >= $kkm->predikat_c && $anggota_kelas->nilai_pengetahuan < $kkm->predikat_b)
                                                                    B
                                                                    <input type="hidden" name="predikat_pengetahuan[]"
                                                                        value="B">
                                                                @elseif($anggota_kelas->nilai_pengetahuan >= $kkm->predikat_b && $anggota_kelas->nilai_pengetahuan <= $kkm->predikat_a)
                                                                    A
                                                                    <input type="hidden" name="predikat_pengetahuan[]"
                                                                        value="A">
                                                                @endif
                                                            </td>

                                                            <td class="text-center">
                                                                {{ $anggota_kelas->nilai_akhir_raport }}</td>
                                                            <input type="hidden" name="nilai_akhir_raport[]"
                                                                value="{{ $anggota_kelas->nilai_akhir_raport }}">

                                                            <td class="text-center">
                                                                @if ($anggota_kelas->nilai_akhir_raport < $kkm->predikat_d)
                                                                    D
                                                                    <input type="hidden" name="predikat_akhir_raport[]"
                                                                        value="D">
                                                                @elseif($anggota_kelas->nilai_akhir_raport >= $kkm->predikat_d && $anggota_kelas->nilai_akhir_raport < $kkm->predikat_c)
                                                                    C
                                                                    <input type="hidden" name="predikat_akhir_raport[]"
                                                                        value="C">
                                                                @elseif($anggota_kelas->nilai_akhir_raport >= $kkm->predikat_c && $anggota_kelas->nilai_akhir_raport < $kkm->predikat_b)
                                                                    B
                                                                    <input type="hidden" name="predikat_akhir_raport[]"
                                                                        value="B">
                                                                @elseif($anggota_kelas->nilai_akhir_raport >= $kkm->predikat_b && $anggota_kelas->nilai_akhir_raport <= $kkm->predikat_a)
                                                                    A
                                                                    <input type="hidden" name="predikat_akhir_raport[]"
                                                                        value="A">
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td class="text-center" colspan="12">Data not available.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer clearfix">
                                        <button type="submit" class="btn btn-primary float-right kirim-nilai-akhir"
                                            onclick=" event.preventDefault(); sendFinalGrade();">Submit Final Grade</button>
                                        <a href="{{ route('km.kirimnilaiakhir.index') }}"
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

<script>
    function sendFinalGrade() {
        Swal.fire({
            title: 'Submit Final Grade?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Kirim!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('.kirim-nilai-akhir').removeAttribute('onclick');
                document.querySelector('.kirim-nilai-akhir').click();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Batal', 'Anda membatalkan pengiriman Final Grade.', 'error');
            }
        });
    }
</script>

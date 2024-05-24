@extends('layouts.main.header')

@section('sidebar')
    @include('layouts.sidebar.walikelas')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            if (
                $user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) &&
                $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])
            ) {
                $dashboard = route('guru.dashboard');
            } elseif ($user->hasAnyRole(['Student']) && $user->hasAnyPermission(['student'])) {
                $dashboard = route('siswa.dashboard');
            } else {
                $dashboard = route('admin.dashboard');
            }
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
                            <h3 class="card-title"><i class="fas fa-check-square"></i> {{ $title }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="bg-info">
                                        <tr>
                                            <th class="text-center" style="width: 5%;">No</th>
                                            <th class="text-center">NIS</th>
                                            <th class="text-center">NISN</th>
                                            <th class="text-center">Student Name</th>
                                            <th class="text-center" style="width: 5%;">L/P</th>
                                            <th class="text-center" style="width: 15%;">Lihat Final Grade Semester</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no_urut = 0; ?>
                                        @if (!$data_anggota_kelas->isEmpty())
                                            @foreach ($data_anggota_kelas->sortBy('siswa.nama_lengkap') as $anggota_kelas)
                                                <?php $no_urut++; ?>
                                                <tr>
                                                    <td class="text-center">{{ $no_urut }}</td>
                                                    <td class="text-center">{{ $anggota_kelas->siswa->nis }}</td>
                                                    <td class="text-center">{{ $anggota_kelas->siswa->nisn }}</td>
                                                    <td>{{ $anggota_kelas->siswa->nama_lengkap }}</td>
                                                    <td class="text-center">{{ $anggota_kelas->siswa->jenis_kelamin }}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-primary btn-sm mt-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-show{{ $anggota_kelas->id }}">
                                                            <i class="fas fa-eye"></i> Lihat Nilai
                                                        </button>

                                                        <!-- Modal Show -->
                                                        <div class="modal fade text-start"
                                                            id="modal-show{{ $anggota_kelas->id }}">
                                                            <div class="modal-dialog modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Final Grade Semester Siswa
                                                                        </h5>

                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-hidden="true"></button>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Header Info  -->
                                                                        <div class="row">
                                                                            <div class="col-sm-2"><strong>Nama
                                                                                    Sekolah</strong></div>
                                                                            <div class="col-sm-6"><strong>:
                                                                                    {{ $sekolah->nama_sekolah }}</strong>
                                                                            </div>
                                                                            <div class="col-sm-2"><strong>Kelas</strong>
                                                                            </div>
                                                                            <div class="col-sm-2"><strong>:
                                                                                    {{ $anggota_kelas->kelas->nama_kelas }}</strong>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-2"><strong>Address</strong>
                                                                            </div>
                                                                            <div class="col-sm-6"><strong>:
                                                                                    {{ $sekolah->alamat }}</strong></div>
                                                                            <div class="col-sm-2"><strong>Semester</strong>
                                                                            </div>
                                                                            <div class="col-sm-2"><strong>:
                                                                                    {{ $semester->semester }}</strong>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-2"><strong>Nama</strong>
                                                                            </div>
                                                                            <div class="col-sm-6"><strong>:
                                                                                    {{ $anggota_kelas->siswa->nama_lengkap }}</strong>
                                                                            </div>
                                                                            <div class="col-sm-2"><strong>Tahun
                                                                                    Pelajaran</strong></div>
                                                                            <div class="col-sm-2"><strong>:
                                                                                    {{ $anggota_kelas->kelas->tapel->tahun_pelajaran }}</strong>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-2"><strong>Nomor Induk /
                                                                                    NISN</strong></div>
                                                                            <div class="col-sm-10"><strong>:
                                                                                    {{ $anggota_kelas->siswa->nis }} /
                                                                                    {{ $anggota_kelas->siswa->nisn }}</strong>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /. Header Info-->

                                                                        <!-- Tabel Nilai  -->
                                                                        <div class="row mt-3">
                                                                            <div class="col-sm-12">
                                                                                <strong>Final Grade SEMESTER SUMATIF DAN
                                                                                    FORMATIF</strong>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered">
                                                                                        <thead class="bg-info">
                                                                                            <tr>
                                                                                                <th class="text-center"
                                                                                                    rowspan="2"
                                                                                                    style="width: 5%;">No
                                                                                                </th>
                                                                                                <th class="text-center"
                                                                                                    rowspan="2"
                                                                                                    style="width: 50%;">Mata
                                                                                                    Pelajaran</th>
                                                                                                <th class="text-center"
                                                                                                    rowspan="2"
                                                                                                    style="width: 5%;">KKM
                                                                                                </th>
                                                                                                <th class="text-center"
                                                                                                    colspan="2"
                                                                                                    style="width: 20%;">
                                                                                                    Sumatif</th>
                                                                                                <th class="text-center"
                                                                                                    colspan="2"
                                                                                                    style="width: 20%;">
                                                                                                    Formatif</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th class="text-center">
                                                                                                    Nilai</th>
                                                                                                <th class="text-center">
                                                                                                    Predikat</th>
                                                                                                <th class="text-center">
                                                                                                    Nilai</th>
                                                                                                <th class="text-center">
                                                                                                    Predikat</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <!-- Nilai Kelompok A  -->
                                                                                            <tr class="bg-light">
                                                                                                <td colspan="7">
                                                                                                    <strong>Kelompok
                                                                                                        A</strong>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <?php $no = 0; ?>

                                                                                            @if ($anggota_kelas->data_nilai_kelompok_a->isEmpty())
                                                                                                <tr class="bg-white">
                                                                                                    <td colspan="7"
                                                                                                        class="text-center">
                                                                                                        Data
                                                                                                        not available yet
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @else
                                                                                                @foreach ($anggota_kelas->data_nilai_kelompok_a->sortBy('pembelajaran.mapel.k13_mapping_mapel.nomor_urut') as $nilai_kelompok_a)
                                                                                                    <?php $no++; ?>
                                                                                                    <tr class="bg-white">
                                                                                                        <td
                                                                                                            class="text-center">
                                                                                                            {{ $no }}
                                                                                                        </td>
                                                                                                        <td>{{ $nilai_kelompok_a->pembelajaran->mapel->nama_mapel }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="text-center">
                                                                                                            {{ $nilai_kelompok_a->kkm }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="text-center">
                                                                                                            {{ $nilai_kelompok_a->nilai_sumatif }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="text-center">
                                                                                                            {{ $nilai_kelompok_a->predikat_sumatif }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="text-center">
                                                                                                            {{ $nilai_kelompok_a->nilai_formatif }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="text-center">
                                                                                                            {{ $nilai_kelompok_a->predikat_formatif }}
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endforeach
                                                                                            @endif
                                                                                            <!-- End Nilai Kelompok A  -->

                                                                                            <!-- Nilai Kelompok B  -->
                                                                                            <tr class="bg-light">
                                                                                                <td colspan="7">
                                                                                                    <strong>Kelompok
                                                                                                        B</strong>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <?php $no = 0; ?>
                                                                                            @if ($anggota_kelas->data_nilai_kelompok_b->isEmpty())
                                                                                                <tr class="bg-white">
                                                                                                    <td colspan="7"
                                                                                                        class="text-center">
                                                                                                        Data
                                                                                                        not available yet
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @else
                                                                                                @foreach ($anggota_kelas->data_nilai_kelompok_b->sortBy('pembelajaran.mapel.k13_mapping_mapel.nomor_urut') as $nilai_kelompok_b)
                                                                                                    <?php $no++; ?>
                                                                                                    <tr class="bg-white">
                                                                                                        <td
                                                                                                            class="text-center">
                                                                                                            {{ $no }}
                                                                                                        </td>
                                                                                                        <td>{{ $nilai_kelompok_b->pembelajaran->mapel->nama_mapel }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="text-center">
                                                                                                            {{ $nilai_kelompok_b->kkm }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="text-center">
                                                                                                            {{ $nilai_kelompok_b->nilai_sumatif }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="text-center">
                                                                                                            {{ $nilai_kelompok_b->predikat_sumatif }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="text-center">
                                                                                                            {{ $nilai_kelompok_b->nilai_formatif }}
                                                                                                        </td>
                                                                                                        <td
                                                                                                            class="text-center">
                                                                                                            {{ $nilai_kelompok_b->predikat_formatif }}
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endforeach
                                                                                            @endif
                                                                                            <!-- End Nilai Kelompok B  -->
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /. Tabel Nilai  -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Modal Show -->
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center" colspan="12">Data not available.</td>
                                            </tr>
                                        @endif
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

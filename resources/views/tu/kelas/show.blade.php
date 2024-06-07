@extends('layouts.main.header')

@section('styles')
    <link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
@endsection

@section('sidebar')
    @include('layouts.sidebar.tu')
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        @php
            $user = Auth::user();
            $dashboard = route('tu.dashboard');
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
                    'title' => 'Kelas',
                    'url' => route('tu.kelas.index'),
                    'active' => true,
                ],
                [
                    'title' => 'Anggota Kelas',
                    'url' => route('tu.kelas.index'),
                    'active' => false,
                ],
            ],
        ])
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $title }}
                                {{ $kelas->nama_kelas }} -
                                @if ($kelas->tingkatan_id == 5)
                                    Jurusan {{ ucwords(strtolower($kelas->jurusan->nama_jurusan)) }} - SHS
                                @else
                                    {{ $kelas->tingkatan->nama_tingkatan }} -
                                    {{ ucwords(strtolower($kelas->jurusan->nama_jurusan)) }} Jurusan -
                                @endif
                                {{ $kelas->tapel->tahun_pelajaran }} Semester
                                @if ($kelas->tapel->semester_id == 1)
                                    Ganjil
                                @else
                                    Genap
                                @endif
                            </h3>
                            <div class="card-tools">
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>NISN</th>
                                            <th>Student Name</th>
                                            <th>Tanggal Lahir</th>
                                            <th>L/P</th>
                                            <th>Pendaftaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($anggota_kelas as $anggota)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $anggota->siswa->nis }}</td>
                                                <td>{{ $anggota->siswa->nisn }}</td>
                                                <td><a class="text-decoration-none text-dark"
                                                        href="{{ route('tu.siswa.show', $anggota->siswa->id) }}">{{ $anggota->siswa->nama_lengkap }}</a>
                                                </td>
                                                @php
                                                    $tanggal_lahir = new DateTime($anggota->siswa->tanggal_lahir);
                                                @endphp
                                                <td>{{ $tanggal_lahir->format('d-m-Y') }}</td>
                                                <td>{{ $anggota->siswa->jenis_kelamin }}</td>
                                                <td>
                                                    @if ($anggota->pendaftaran == 1)
                                                        Siswa Baru
                                                    @elseif ($anggota->pendaftaran == 2)
                                                        Pindahan
                                                    @elseif ($anggota->pendaftaran == 3)
                                                        Naik Kelas
                                                    @elseif ($anggota->pendaftaran == 4)
                                                        Naik Kelas
                                                    @elseif ($anggota->pendaftaran == 5)
                                                        Mengulang
                                                    @endif
                                                </td>
                                            </tr>
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

@push('custom-scripts')
    <script>
        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()
    </script>
@endpush

@section('footer')
    @include('layouts.main.footer')
@endsection

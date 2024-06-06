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
                    'title' => $title,
                    'url' => route('admin.siswa.trash'),
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
                            <h3 class="card-title"> {{ $title }}</h3>
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
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($anggotaKelasTrashed as $anggota)
                                            <?php $no++; ?>
                                            <tr>
                                                @if ($anggota->siswa)
                                                    <td>{{ $no }}</td>
                                                    <td>{{ $anggota->siswa->nis ?? '-' }}</td>
                                                    <td>{{ $anggota->siswa->nisn ?? '-' }}</td>
                                                    <td>
                                                        @if ($anggota->siswa->nama_lengkap)
                                                            <a class="text-decoration-none text-body"
                                                                href="{{ route('admin.siswa.show', $anggota->siswa->id) }}">
                                                                {{ $anggota->siswa->nama_lengkap }}
                                                            </a>
                                                        @else
                                                            {{ '-' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($anggota->siswa->tanggal_lahir)
                                                            {{ (new DateTime($anggota->siswa->tanggal_lahir))->format('d-m-Y') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{ $anggota->siswa->jenis_kelamin ?? '-' }}</td>
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
                                                    <td>

                                                    <td class=" text-center">
                                                        <div class="d-flex gap-2">
                                                            <div data-bs-toggle="tooltip" data-bs-original-title="Restore">
                                                                <form method="POST"
                                                                    action="{{ route('admin.kelas.anggota_kelas.restore', ['id' => $anggota->id]) }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                            class="fas fa-undo"></i></button>
                                                                </form>
                                                            </div>
                                                            <div data-bs-toggle="tooltip"
                                                                data-bs-original-title="Delete Permanent">
                                                                <form method="POST"
                                                                    action="{{ route('admin.kelas.anggota_kelas.permanent-delete', ['id' => $anggota->id]) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger"><i
                                                                            class="fas fa-trash-alt"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    </td>
                                                @else
                                                    <!-- Handle the case where $anggota->siswa is null -->
                                                    <td colspan="8" class="text-center">Siswa not available</td>
                                                @endif
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

@section('footer')
    @include('layouts.main.footer')
@endsection

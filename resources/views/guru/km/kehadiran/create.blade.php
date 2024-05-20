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
                    'title' => 'Kehadiran Siswa',
                    'url' => route('km.kehadiran.index'),
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
                            <h3 class="card-title"><i class="fas fa-user-check"></i> {{ $title }}</h3>
                        </div>
                        <form action="{{ route('km.kehadiran.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="bg-info">
                                            <tr>
                                                <th class="text-center" style="width: 5%;">No</th>
                                                <th class="text-center" style="width: 5%;">NIS</th>
                                                <th class="text-center" style="width: 35%;">Nama Siswa</th>
                                                <th class="text-center" style="width: 5%;">L/P</th>
                                                <th class="text-center" style="width: 5%;">Kelas</th>
                                                <th class="text-center" style="width: 15%;">Sakit</th>
                                                <th class="text-center" style="width: 15%;">Izin</th>
                                                <th class="text-center" style="width: 15%;">Tanpa Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            @if (!$data_anggota_kelas->isEmpty())
                                                @foreach ($data_anggota_kelas->sortBy('siswa.nama_lengkap') as $anggota_kelas)
                                                    <?php $no++; ?>
                                                    <tr>
                                                        <input type="hidden" name="anggota_kelas_id[]"
                                                            value="{{ $anggota_kelas->id }}">
                                                        <td class="text-center">{{ $no }}</td>
                                                        <td class="text-center">{{ $anggota_kelas->siswa->nis }}</td>
                                                        <td>{{ $anggota_kelas->siswa->nama_lengkap }}</td>
                                                        <td class="text-center">{{ $anggota_kelas->siswa->jenis_kelamin }}
                                                        </td>
                                                        <td class="text-center">{{ $anggota_kelas->kelas->nama_kelas }}</td>
                                                        <td>
                                                            <input type="number" class="form-control" name="sakit[]"
                                                                value="{{ $anggota_kelas->sakit }}" required
                                                                oninvalid="this.setCustomValidity('Isian tidak boleh kosong')"
                                                                oninput="setCustomValidity('')">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" name="izin[]"
                                                                value="{{ $anggota_kelas->izin }}" required
                                                                oninvalid="this.setCustomValidity('Isian tidak boleh kosong')"
                                                                oninput="setCustomValidity('')">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control"
                                                                name="tanpa_keterangan[]"
                                                                value="{{ $anggota_kelas->tanpa_keterangan }}" required
                                                                oninvalid="this.setCustomValidity('Isian tidak boleh kosong')"
                                                                oninput="setCustomValidity('')">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="text-center" colspan="12">Data tidak tersedia.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary float-right ml-2">Simpan</button>
                                <a href="{{ route('km.kehadiran.index') }}" class="btn btn-default float-right">Batal</a>
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

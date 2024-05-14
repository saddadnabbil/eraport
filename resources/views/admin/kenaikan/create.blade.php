@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.index')
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
                    'title' => 'Kenaikan Kelas',
                    'url' => route('km.kenaikan.index'),
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
                            <h3 class="card-title"><i class="fas fa-layer-group"></i> {{ $title }}</h3>
                        </div>
                        <form action="{{ route('km.kenaikan.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="bg-info">
                                            <tr>
                                                <th class="text-center" style="width: 5%;">No</th>
                                                <th class="text-center" style="width: 5%;">NIS</th>
                                                <th class="text-center" style="width: 25%;">Nama Siswa</th>
                                                <th class="text-center" style="width: 5%;">L/P</th>
                                                <th class="text-center" style="width: 10%;">Kelas Saat Ini</th>
                                                <th class="text-center" colspan="2">Keputusan Naik Kelas / Lulus</th>
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
                                                            <select class="form-control form-select select2"
                                                                name="keputusan[]" style="width: 100%;" required>
                                                                <option value=""
                                                                    @if ($anggota_kelas->keputusan == null) selected @endif>--
                                                                    Pilih Keputusan --</option>
                                                                @if ($anggota_kelas->kelas->tingkatan_id != $tingkatan_akhir)
                                                                    <option value="1"
                                                                        @if ($anggota_kelas->keputusan == 1) selected @endif>
                                                                        Naik Kelas</option>
                                                                    <option value="2"
                                                                        @if ($anggota_kelas->keputusan == 2) selected @endif>
                                                                        Tinggal Dikelas</option>
                                                                @else
                                                                    <option value="3"
                                                                        @if ($anggota_kelas->keputusan == 3) selected @endif>
                                                                        Lulus</option>
                                                                    <option value="4"
                                                                        @if ($anggota_kelas->keputusan == 4) selected @endif>
                                                                        Tidak Lulus</option>
                                                                @endif
                                                            </select>
                                                        </td>
                                                        @if ($anggota_kelas->kelas->tingkatan_id != $tingkatan_akhir)
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    name="kelas_tujuan[]" placeholder="Kelas Tujuan"
                                                                    value="{{ $anggota_kelas->kelas_tujuan }}" required>
                                                            </td>
                                                        @endif
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
                                <button type="submit" class="btn btn-primary float-right">Simpan</button>
                                <a href="{{ route('km.kenaikan.index') }}"
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

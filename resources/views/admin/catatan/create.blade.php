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
                    'title' => 'Catatan Wali Kelas',
                    'url' => route('catatanadmin.index'),
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
                            <h3 class="card-title"><i class="fas fa-edit"></i> {{ $title }}</h3>
                        </div>
                        <form action="{{ route('catatanadmin.store') }}" method="POST">
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
                                                <th class="text-center" style="width: 5%;">Kelas</th>
                                                <th class="text-center">Catatan Perkembangan Peserta Didik</th>
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
                                                            <textarea class="form-control" name="catatan_wali_kelas[]" rows="3" minlength="30" maxlength="200"
                                                                oninvalid="this.setCustomValidity('Catatan harus berisi antara 20 s/d 100 karekter')"
                                                                oninput="setCustomValidity('')">{{ $anggota_kelas->catatan_wali_kelas }}</textarea>
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
                                <button type="submit" class="btn btn-primary float-right">Simpan</button>
                                <a href="{{ route('kenaikanadmin.index') }}"
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

@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.guru')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            $dashboard = route('guru.dashboard');
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
                            <h3 class="card-title"> {{ $title }} {{ $ekstrakulikuler->nama_ekstrakulikuler }}
                                {{ $ekstrakulikuler->tapel->tahun_pelajaran }} Semester
                                @if ($ekstrakulikuler->tapel->semester_id == 1)
                                    Ganjil
                                @else
                                    Genap
                                @endif
                            </h3>
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Tambah" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-tambah">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal tambah  -->
                        <div class="modal fade" id="modal-tambah">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah {{ $title }}</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                        </button>
                                    </div>
                                    <form action="{{ route('guru.ekstrakulikuler.anggota') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="callout callout-info">
                                                            <label>
                                                                Ekstrakulikuler
                                                                {{ $ekstrakulikuler->nama_ekstrakulikuler }}
                                                                {{ $ekstrakulikuler->tapel->tahun_pelajaran }} Semester
                                                                @if ($ekstrakulikuler->tapel->semester_id == 1)
                                                                    Ganjil
                                                                @else
                                                                    Genap
                                                                @endif
                                                            </label>
                                                            <p>Untuk menambahkan anggota ekstrakulikuler, silahkan
                                                                pindahkan nama siswa ke kolom sebelah kanan lalu klik
                                                                tombol simpan.</p>
                                                        </div>
                                                        <input type="hidden" name="ekstrakulikuler_id"
                                                            value="{{ $ekstrakulikuler->id }}">
                                                        <select class="duallistbox" multiple="multiple"
                                                            name="anggota_kelas_id[]">
                                                            @foreach ($siswa_belum_masuk_ekstrakulikuler as $belum_masuk_ekstrakulikuler)
                                                                <option value="{{ $belum_masuk_ekstrakulikuler->id }}">
                                                                    {{ $belum_masuk_ekstrakulikuler->siswa->nis }} |
                                                                    {{ $belum_masuk_ekstrakulikuler->siswa->nisn }} |
                                                                    {{ $belum_masuk_ekstrakulikuler->siswa->nama_lengkap }}
                                                                    ({{ $belum_masuk_ekstrakulikuler->kelas->nama_kelas }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- /.form-group -->
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <div class="modal-footer justify-content-end">
                                            <button type="button" class="btn btn-default"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal tambah -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>NISN</th>
                                            <th>Nama Siswa</th>
                                            <th>L/P</th>
                                            <th>Kelas</th>
                                            <th>Hapus Anggota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($anggota_ekstrakulikuler->sortBy('anggota_kelas.siswa.nama_lengkap') as $anggota)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $anggota->anggota_kelas->siswa->nis }}</td>
                                                <td>{{ $anggota->anggota_kelas->siswa->nisn }}</td>
                                                <td>{{ $anggota->anggota_kelas->siswa->nama_lengkap }}</td>
                                                <td>{{ $anggota->anggota_kelas->siswa->jenis_kelamin }}</td>
                                                <td>{{ $anggota->anggota_kelas->kelas->nama_kelas }}</td>
                                                <td>
                                                    <form
                                                        action="{{ route('guru.ekstrakulikuler.anggota.delete', $anggota->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm mt-1"
                                                            onclick="return confirm('Hapus {{ $title }} ?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
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

@section('footer')
    @include('layouts.main.footer')
@endsection

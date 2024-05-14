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
                    'title' => 'Prestasi Siswa',
                    'url' => route('km.prestasi.index'),
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
                            <h3 class="card-title"> {{ $title }}</h3>
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
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah {{ $title }}</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                        </button>
                                    </div>
                                    <form action="{{ route('km.prestasi.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="anggota_kelas_id" class="col-sm-3 col-form-label">Siswa</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" id="anggota_kelas_id"
                                                        name="anggota_kelas_id" required>
                                                        <option value="">-- Pilih Siswa --</option>
                                                        @foreach ($data_anggota_kelas as $anggota)
                                                            <option value="{{ $anggota->id }}">{{ $anggota->siswa->nis }} |
                                                                {{ $anggota->siswa->nisn }} |
                                                                {{ $anggota->siswa->nama_lengkap }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="nama_prestasi" class="col-sm-3 col-form-label">Nama
                                                    Prestasi</label>
                                                <div class="col-sm-9 pt-1">
                                                    <input type="text" name="nama_prestasi" id="nama_prestasi"
                                                        class="form-control" placeholder="Nama Prestasi" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="jenis_prestasi" class="col-sm-3 col-form-label">Jenis
                                                    Prestasi</label>
                                                <div class="col-sm-9 pt-1">
                                                    <label class="form-check-label me-3"><input type="radio"
                                                            name="jenis_prestasi" value="1" required> Akademik</label>
                                                    <label class="form-check-label me-3"><input type="radio"
                                                            name="jenis_prestasi" value="2" required> Non
                                                        Akademik</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="jenis_prestasi" class="col-sm-3 col-form-label">Tingkatan
                                                    Prestasi</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" id="tingkat_prestasi"
                                                        name="tingkat_prestasi" required>
                                                        <option value="">-- Pilih Tingkatan --</option>
                                                        <option value="1">Internations</option>
                                                        <option value="2">National</option>
                                                        <option value="3">Province</option>
                                                        <option value="4">City</option>
                                                        <option value="5">Disctrict</option>
                                                        <option value="6">Inter School</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="deskripsi" placeholder="Deskripsi Prestasi" rows="3" minlength="20"
                                                        maxlength="200" required oninvalid="this.setCustomValidity('Deskripsi harus berisi antara 20 s/d 100 karekter')"
                                                        oninput="setCustomValidity('')"></textarea>
                                                </div>
                                            </div>

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
                                <table id="zero_config" class="table table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>Nama Siswa</th>
                                            <th>L/P</th>
                                            <th>Kelas</th>
                                            <th>Nama Prestasi</th>
                                            <th>Jenis Prestasi</th>
                                            <th>Tingkatan Prestasi</th>
                                            <th>Deskripsi Prestasi</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_prestasi_siswa->sortBy('anggota_kelas.siswa.nama_lengkap') as $prestasi)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $prestasi->anggota_kelas->siswa->nis }}</td>
                                                <td>{{ $prestasi->anggota_kelas->siswa->nama_lengkap }}</td>
                                                <td>{{ $prestasi->anggota_kelas->siswa->jenis_kelamin }}</td>
                                                <td>{{ $prestasi->anggota_kelas->kelas->nama_kelas }}</td>
                                                <td>{{ $prestasi->nama_prestasi }}</td>
                                                <td>
                                                    @if ($prestasi->jenis_prestasi == 1)
                                                        Akademik
                                                    @else
                                                        Non Akademik
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($prestasi->tingkat_prestasi == 1)
                                                        Internations
                                                    @elseif($prestasi->tingkat_prestasi == 2)
                                                        National
                                                    @elseif($prestasi->tingkat_prestasi == 3)
                                                        Province
                                                    @elseif($prestasi->tingkat_prestasi == 4)
                                                        City
                                                    @elseif($prestasi->tingkat_prestasi == 5)
                                                        District
                                                    @elseif($prestasi->tingkat_prestasi == 6)
                                                        Inter School
                                                    @endif
                                                </td>
                                                <td>{{ $prestasi->deskripsi }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('prestasi.destroy', $prestasi->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-warning btn-sm mt-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-edit{{ $prestasi->id }}">
                                                            <i class="fas fa-pen"></i>
                                                        </button>
                                                        <button type="submit" class="btn btn-danger btn-sm mt-1"
                                                            onclick="return confirm('Hapus {{ $title }} ?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit  -->
                                            <div class="modal fade" id="modal-edit{{ $prestasi->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tambah {{ $title }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <form action="{{ route('km.prestasi.update', $prestasi->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="anggota_kelas_id"
                                                                        class="col-sm-3 col-form-label">Siswa</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" name="anggota_kelas_id"
                                                                            id="anggota_kelas_id" class="form-control"
                                                                            value="{{ $prestasi->anggota_kelas->siswa->nama_lengkap }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="nama_prestasi"
                                                                        class="col-sm-3 col-form-label">Nama
                                                                        Prestasi</label>
                                                                    <div class="col-sm-9 pt-1">
                                                                        <input type="text" name="nama_prestasi"
                                                                            id="nama_prestasi" class="form-control"
                                                                            value="{{ $prestasi->nama_prestasi }}"
                                                                            required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="jenis_prestasi"
                                                                        class="col-sm-3 col-form-label">Jenis
                                                                        Prestasi</label>
                                                                    <div class="col-sm-9 pt-1">
                                                                        <label class="form-check-label me-3"><input
                                                                                type="radio" name="jenis_prestasi"
                                                                                value="1"
                                                                                {{ $prestasi->jenis_prestasi == 1 ? 'checked' : '' }}
                                                                                required> Akademik</label>
                                                                        <label class="form-check-label me-3"><input
                                                                                type="radio" name="jenis_prestasi"
                                                                                value="2"
                                                                                {{ $prestasi->jenis_prestasi == 2 ? 'checked' : '' }}
                                                                                required> Non Akademik</label>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="jenis_prestasi"
                                                                        class="col-sm-3 col-form-label">Tingkatan
                                                                        Prestasi</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control form-select select2"
                                                                            id="tingkat_prestasi" name="tingkat_prestasi"
                                                                            required>
                                                                            <option value="">-- Pilih Tingkatan --
                                                                            </option>
                                                                            <option value="1"
                                                                                {{ $prestasi->tingkat_prestasi == 1 ? 'selected' : '' }}>
                                                                                Internations</option>
                                                                            <option value="2"
                                                                                {{ $prestasi->tingkat_prestasi == 2 ? 'selected' : '' }}>
                                                                                National</option>
                                                                            <option value="3"
                                                                                {{ $prestasi->tingkat_prestasi == 3 ? 'selected' : '' }}>
                                                                                Province</option>
                                                                            <option value="4"
                                                                                {{ $prestasi->tingkat_prestasi == 4 ? 'selected' : '' }}>
                                                                                City</option>
                                                                            <option value="5"
                                                                                {{ $prestasi->tingkat_prestasi == 5 ? 'selected' : '' }}>
                                                                                District</option>
                                                                            <option value="6"
                                                                                {{ $prestasi->tingkat_prestasi == 6 ? 'selected' : '' }}>
                                                                                Inter School</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="deskripsi"
                                                                        class="col-sm-3 col-form-label">Deskripsi</label>
                                                                    <div class="col-sm-9">
                                                                        <textarea class="form-control" name="deskripsi" placeholder="Deskripsi Prestasi" rows="3" minlength="20"
                                                                            maxlength="200" required oninvalid="this.setCustomValidity('Deskripsi harus berisi antara 20 s/d 100 karekter')"
                                                                            oninput="setCustomValidity('')">{{ $prestasi->deskripsi }}</textarea>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer justify-content-end">
                                                                <button type="button" class="btn btn-default"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal Edit -->
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

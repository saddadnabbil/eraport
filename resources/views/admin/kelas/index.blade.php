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
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-layer-group  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Playgroup</span>
                            <span class="info-box-number">{{ $jumlah_kelas_play_group }}
                                <small>{{ $jumlah_kelas_junior_high_school > 1 ? 'classes' : 'class' }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-book  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Kindergarten A</span>
                            <span class="info-box-number">{{ $jumlah_kelas_kinder_garten_a }}
                                <small>{{ $jumlah_kelas_kinder_garten_a > 1 ? 'classes' : 'class' }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-book  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Kindergarten B</span>
                            <span class="info-box-number">{{ $jumlah_kelas_kinder_garten_b }}
                                <small>{{ $jumlah_kelas_kinder_garten_b > 1 ? 'classes' : 'class' }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <!-- fix for small devices only -->
                {{-- <div class="clearfix hidden-md-up"></div> --}}

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Primary School</span>
                            <span class="info-box-number">{{ $jumlah_kelas_primary_school }}
                                <small>{{ $jumlah_kelas_junior_high_school > 1 ? 'classes' : 'class' }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fas fa-book-reader text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Junior High School</span>
                            <span class="info-box-number">{{ $jumlah_kelas_junior_high_school }}
                                <small>{{ $jumlah_kelas_junior_high_school > 1 ? 'classes' : 'class' }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fas fa-book-reader  text-light"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Senior High School</span>
                            <span class="info-box-number">{{ $jumlah_kelas_senior_high_school }}
                                <small>{{ $jumlah_kelas_junior_high_school > 1 ? 'class' : 'classes' }}</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
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
                                    <form action="{{ route('kelas.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="tahun_pelajaran" class="col-sm-3 col-form-label">Tahun
                                                    Pelajaran</label>
                                                <div class="col-sm-9">
                                                    @if ($tapel->semester_id == 1)
                                                        <input type="text" name="tahun_pelajaran" class="form-control"
                                                            value="{{ $tapel->tahun_pelajaran }} Semester Ganjil" readonly>
                                                    @else
                                                        <input type="text" name="tahun_pelajaran" class="form-control"
                                                            value="{{ $tapel->tahun_pelajaran }} Semester Genap" readonly>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tingkatan_id" class="col-sm-3 col-form-label">Tingkatan</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" name="tingkatan_id"
                                                        style="width: 100%;" required>
                                                        <option value="">-- Pilih Tingkatan --</option>
                                                        @foreach ($data_tingkatan as $tingkatan)
                                                            <option value="{{ $tingkatan->id }}">
                                                                {{ $tingkatan->nama_tingkatan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jurusan_id" class="col-sm-3 col-form-label">Jurusan
                                                    Kelas</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" name="jurusan_id"
                                                        style="width: 100%;" required>
                                                        <option value="">-- Pilih Jurusan Kelas --</option>
                                                        @foreach ($data_jurusan as $jurusan)
                                                            <option value="{{ $jurusan->id }}">
                                                                {{ $jurusan->nama_jurusan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nama_kelas" class="col-sm-3 col-form-label">Nama Kelas</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nama_kelas"
                                                        name="nama_kelas" placeholder="Nama Kelas"
                                                        value="{{ old('nama_kelas') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="guru_id" class="col-sm-3 col-form-label">Wali Kelas</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" name="guru_id"
                                                        style="width: 100%;" required>
                                                        <option value="">-- Pilih Wali Kelas --</option>
                                                        @foreach ($data_guru as $guru)
                                                            <option value="{{ $guru->id }}">
                                                                {{ $guru->karyawan->nama_lengkap }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Semester</th>
                                            <th>Tingkatan</th>
                                            <th>Jurusan</th>
                                            <th>Kelas</th>
                                            <th>Wali Kelas</th>
                                            <th>Jml Anggota</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_kelas as $kelas)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $kelas->tapel->tahun_pelajaran }}
                                                    @if ($kelas->tapel->semester_id == 1)
                                                        Ganjil
                                                    @else
                                                        Genap
                                                    @endif
                                                </td>
                                                <td>{{ $kelas->tingkatan->nama_tingkatan }}</td>
                                                <td>{{ $kelas->jurusan->nama_jurusan }}</td>
                                                <td>{{ $kelas->nama_kelas }}</td>
                                                <td>
                                                    @if ($kelas->guru)
                                                        {{ $kelas->guru->karyawan->nama_lengkap }}
                                                        {{ $kelas->guru->gelar }}
                                                    @else
                                                        Guru not assigned
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('kelas.show', $kelas->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-list"></i> {{ $kelas->jumlah_anggota }} Siswa
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('kelas.destroy', $kelas->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-warning btn-sm mt-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-edit{{ $kelas->id }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <button type="submit" class="btn btn-danger btn-sm mt-1"
                                                            onclick="return confirm('Hapus {{ $title }} ?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $kelas->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <form action="{{ route('kelas.update', $kelas->id) }}"
                                                            method="POST">
                                                            {{ method_field('PATCH') }}
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="tingkatan_id"
                                                                        class="col-sm-3 col-form-label">Tingkatan</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control form-select select2"
                                                                            name="tingkatan_id" style="width: 100%;"
                                                                            required>
                                                                            <option value=""></option>
                                                                            @foreach ($data_tingkatan as $tingkatan)
                                                                                <option value="{{ $tingkatan->id }}"
                                                                                    @if ($tingkatan->id == $kelas->tingkatan->id) selected @endif>
                                                                                    {{ $tingkatan->nama_tingkatan }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="jurusan_id"
                                                                        class="col-sm-3 col-form-label">Jurusan</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control form-select select2"
                                                                            name="jurusan_id" style="width: 100%;"
                                                                            required>
                                                                            <option value=""></option>
                                                                            @foreach ($data_jurusan as $jurusan)
                                                                                <option value="{{ $jurusan->id }}"
                                                                                    @if ($jurusan->id == $kelas->jurusan->id) selected @endif>
                                                                                    {{ $jurusan->nama_jurusan }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="nama_kelas"
                                                                        class="col-sm-3 col-form-label">Nama Kelas</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="nama_kelas" name="nama_kelas"
                                                                            value="{{ $kelas->nama_kelas }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="guru_id"
                                                                        class="col-sm-3 col-form-label">Wali Kelas</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control form-select select2"
                                                                            name="guru_id" style="width: 100%;" required>
                                                                            <option value="" disabled selected>--
                                                                                Pilih Wali Kelas --</option>
                                                                            @foreach ($data_guru as $guru)
                                                                                <option value="{{ $guru->id }}"
                                                                                    @if ($kelas->guru && $guru->id == $kelas->guru->id) selected @endif>
                                                                                    {{ $guru->karyawan->nama_lengkap }}

                                                                                </option>
                                                                            @endforeach
                                                                        </select>
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
                                            <!-- End Modal edit -->
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

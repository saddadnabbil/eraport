@extends('layouts.main.header')

@section('styles')
    <link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
@endsection

@section('sidebar')
    @include('layouts.sidebar.admin')
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
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
                    'title' => 'Kelas',
                    'url' => route('admin.kelas.index'),
                    'active' => true,
                ],
                [
                    'title' => 'Anggota Kelas',
                    'url' => route('admin.kelas.index'),
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
                                <div data-bs-toggle="tooltip" title="Tambah" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-tambah">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                {{-- get form trash --}}
                                <div data-bs-toggle="tooltip" title="Trash" class="d-inline-block" class="d-inline-block">
                                    {{-- Form untuk mengirimkan permintaan POST dengan menyertakan nilai $kelas->id --}}
                                    <form action="{{ route('admin.kelas.anggota_kelas.trash', ['id' => $kelas->id]) }}"
                                        method="get">
                                        @csrf
                                        <button type="submit" class="btn btn-tool btn-sm" data-bs-toggle="tooltip"
                                            title="Trash">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
                                    <form action="{{ route('admin.kelas.anggota') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="tapel_id" value="{{ $tapel->id }}">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="callout callout-info">
                                                            <label>
                                                                {{ $kelas->nama_kelas }}
                                                                {{ $kelas->tapel->tahun_pelajaran }} Semester
                                                                @if ($kelas->tapel->semester_id == 1)
                                                                    Ganjil
                                                                @else
                                                                    Genap
                                                                @endif
                                                            </label>
                                                            <p>Untuk menambahkan anggota kelas, silahkan pindahkan nama
                                                                siswa ke kolom sebelah kanan lalu klik tombol simpan.</p>
                                                        </div>
                                                        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                                        <select class="duallistbox" multiple="multiple" name="siswa_id[]">
                                                            @foreach ($siswa_belum_masuk_kelas as $belum_masuk_kelas)
                                                                <option value="{{ $belum_masuk_kelas->id }}">
                                                                    {{ $belum_masuk_kelas->nis }} |
                                                                    {{ $belum_masuk_kelas->nisn }} |
                                                                    {{ $belum_masuk_kelas->nama_lengkap }}
                                                                    ({{ $belum_masuk_kelas->kelas_sebelumhya }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="form-group row pt-3 pb-0 justify-content-end">
                                                            <label for="pendaftaran" class="col-sm-2 col-form-label">Jenis
                                                                Pendaftaran</label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control form-select" name="pendaftaran"
                                                                    required>
                                                                    <option value="">-- Pilih Jenis Pendaftaran --
                                                                    </option>
                                                                    <option value="2">Pindahan</option>
                                                                    @if ($kelas->tapel->semester_id == 1)
                                                                        <option value="1">Siswa Baru</option>
                                                                        <option value="3">Naik Kelas</option>
                                                                        <option value="5">Mengulang</option>
                                                                    @else
                                                                        <option value="4">Lanjutan Semester</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
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
                                            <th>Tanggal Lahir</th>
                                            <th>L/P</th>
                                            <th>Pendaftaran</th>
                                            <th>Aksi</th>
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
                                                        href="{{ route('admin.siswa.show', $anggota->siswa->id) }}">{{ $anggota->siswa->nama_lengkap }}</a>
                                                </td>
                                                <td>{{ $anggota->siswa->tanggal_lahir->format('d-m-Y') }}</td>
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
                                                <td>

                                                    <form action="{{ route('admin.kelas.anggota.delete', $anggota->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="{{ route('admin.siswa.show', $anggota->siswa->id) }}"
                                                            class="btn btn-warning btn-sm mt-1"><i
                                                                class="fas fa-eye"></i></a>
                                                        <button type="submit" class="btn btn-danger btn-sm mt-1"
                                                            onclick="return confirm('Hapus {{ $title }} ?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                    {{-- <input type="hidden" name="siswa_id"
                                                        value="{{ $anggota->siswa->id }}">
                                                    <a href="{{ route('admin.siswa.show', $anggota->siswa->id) }}"
                                                        class="btn btn-warning btn-sm mt-1"><i class="fas fa-eye"></i></a>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit{{ $anggota->id }}">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button> --}}
                                                    {{-- <button type="submit" class="btn btn-danger btn-sm mt-1"
                                                            onclick="return confirm('Pindahkan {{ $title }} ?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button> --}}


                                                    <!-- Modal tambah  -->
                                                    <div class="modal fade" id="modal-edit{{ $anggota->id }}">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Pindahkan {{ $title }}
                                                                    </h5>

                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-hidden="true"></button>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('admin.kelas.anggota.pindah_kelas', $anggota->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <input type="hidden" name="siswa_id"
                                                                                        value="{{ $anggota->siswa->id }}">
                                                                                    <div class="form-group row pt-3 pb-0 ">
                                                                                        <label for="pendaftaran"
                                                                                            class="col-sm-2 col-form-label">Nama
                                                                                            Siswa</label>
                                                                                        <div class="col-sm-10">
                                                                                            <input class="form-control"
                                                                                                type="text"
                                                                                                name="nama_siswa"
                                                                                                id="nama_siswa"
                                                                                                placeholder="{{ $anggota->siswa->nama_lengkap }}"
                                                                                                class="form-control"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label for="pendaftaran"
                                                                                            class="col-sm-2 col-form-label">Tujuan
                                                                                            Kelas</label>
                                                                                        <div class="col-sm-10">
                                                                                            <select
                                                                                                class="form-control form-select"
                                                                                                name="kelas_id" required>
                                                                                                <option value="">
                                                                                                    --
                                                                                                    Pilih Kelas
                                                                                                    --
                                                                                                </option>
                                                                                                @foreach ($data_kelas as $kelas)
                                                                                                    <option
                                                                                                        value="{{ $kelas->id }}"
                                                                                                        @if ($anggota->siswa->kelas_id == $kelas->id) selected @endif>
                                                                                                        {{ $kelas->nama_kelas }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

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
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal tambah -->
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

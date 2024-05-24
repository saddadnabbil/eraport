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
                            <h3 class="card-title"> {{ $title }}</h3>
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Create" class="d-inline-block">
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
                                    </div>
                                    <form action="{{ route('guru.ekstrakulikuler.store') }}" method="POST">
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
                                                <label for="nama_ekstrakulikuler" class="col-sm-3 col-form-label">Nama
                                                    Ekstrakulikuler</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nama_ekstrakulikuler"
                                                        name="nama_ekstrakulikuler" placeholder="Nama Ekstrakulikuler"
                                                        value="{{ old('nama_ekstrakulikuler') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="pembina_id" class="col-sm-3 col-form-label">Pembina</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" name="pembina_id"
                                                        style="width: 100%;" required>
                                                        <option value="">-- Pilih Pembina --</option>
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
                                            <button type="submit" class="btn btn-primary">Save</button>
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
                                            <th>Nama Ekstrakulikuler</th>
                                            <th>Pembina</th>
                                            <th>Jml Anggota</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_ekstrakulikuler as $ekstrakulikuler)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $ekstrakulikuler->tapel->tahun_pelajaran }}
                                                    @if ($ekstrakulikuler->tapel->semester_id == 1)
                                                        Ganjil
                                                    @else
                                                        Genap
                                                    @endif
                                                </td>
                                                <td>{{ $ekstrakulikuler->nama_ekstrakulikuler }}</td>
                                                <td>{{ $ekstrakulikuler->pembina->nama_lengkap }}
                                                    {{ $ekstrakulikuler->pembina->gelar }}</td>
                                                <td>
                                                    <a href="{{ route('guru.ekstrakulikuler.show', $ekstrakulikuler->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-list"></i> {{ $ekstrakulikuler->jumlah_anggota }}
                                                        Anggota
                                                    </a>
                                                </td>
                                                <td>
                                                    <form
                                                        action="{{ route('guru.ekstrakulikuler.destroy', $ekstrakulikuler->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-warning btn-sm mt-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-edit{{ $ekstrakulikuler->id }}">
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
                                            <div class="modal fade" id="modal-edit{{ $ekstrakulikuler->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('guru.ekstrakulikuler.update', $ekstrakulikuler->id) }}"
                                                            method="POST">
                                                            {{ method_field('PATCH') }}
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="nama_ekstrakulikuler"
                                                                        class="col-sm-3 col-form-label">Nama
                                                                        Ekstrakulikuler</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="nama_ekstrakulikuler"
                                                                            name="nama_ekstrakulikuler"
                                                                            value="{{ $ekstrakulikuler->nama_ekstrakulikuler }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="pembina_id"
                                                                        class="col-sm-3 col-form-label">Pembina</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control form-select select2"
                                                                            name="pembina_id" style="width: 100%;"
                                                                            required>
                                                                            <option value="" disabled>-- Pilih
                                                                                Pembina -- </option>
                                                                            @foreach ($data_guru as $guru)
                                                                                <option value="{{ $guru->id }}"
                                                                                    @if ($guru->id == $ekstrakulikuler->pembina->id) selected @endif>
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
                                                                    class="btn btn-primary">Save</button>
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

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

            {{-- data table --}}
            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
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
                                        </button>
                                    </div>
                                    <form action="{{ route('p5.project.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="semester_id" value="{{ $tapel->semester_id }}">
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="pt_tema_id" class="col-sm-3 col-form-label">Tema Projek</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" name="p5_tema_id"
                                                        id="pt_tema_id">
                                                        <option value="">Pilih Tema Projek</option>
                                                        @foreach ($dataTema as $tema)
                                                            <option value="{{ $tema->id }}"
                                                                @if (old('p5_tema_id') == $tema->id) selected @endif>
                                                                {{ $tema->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="guru_id" class="col-sm-3 col-form-label">Pembina Projek</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" name="guru_id"
                                                        id="guru_id">
                                                        <option value="">Pilih Pembina Projek</option>
                                                        @foreach ($dataGuru as $guru)
                                                            <option value="{{ $guru->id }}"
                                                                @if (old('guru_id') == $guru->id) selected @endif>
                                                                {{ $guru->karyawan->nama_lengkap }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="kelas_id" class="col-sm-3 col-form-label">Class</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" name="kelas_id"
                                                        id="kelas_id">
                                                        <option value="">Select Class</option>
                                                        @foreach ($dataKelas as $kelas)
                                                            <option value="{{ $kelas->id }}"
                                                                @if (old('kelas_id') == $kelas->id) selected @endif>
                                                                {{ $kelas->nama_kelas }}
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
                                            <th>Class</th>
                                            <th>Tema</th>
                                            <th>Subelement</th>
                                            <th>Pembina</th>
                                            <th>Siswa</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($dataProject as $project)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $project->kelas->nama_kelas }}</td>
                                                <td>{{ $project->p5_tema->name }}</td>
                                                <td>{{ $project->subelement_active_count }}</td>
                                                <td>{{ $project->guru->karyawan->nama_lengkap }}</td>
                                                <td>{{ $project->kelas->anggota_kelas->count() }}</td>
                                                <td class="text-center d-flex gap-2 justify-content-center">
                                                    <div data-bs-toggle="tooltip"
                                                        data-bs-original-title=" {{ isset($project) && $project->subelement_active_count > 0 ? 'Nilai' : 'Belum ada Subelemen Projek, tekan tombol Edit untuk menambahkan.' }}">
                                                        <a href="{{ isset($project) && $project->subelement_active_count > 0 ? route('p5.project.show', $project->id) : '#' }}"
                                                            class="btn btn-success btn-sm mt-1{{ isset($project) && $project->subelement_active_count <= 0 ? ' disabled' : '' }}"
                                                            role="button"
                                                            aria-disabled="{{ isset($project) && $project->subelement_active_count <= 0 ? 'true' : 'false' }}">
                                                            <i class="fas fa-cog"></i>
                                                        </a>
                                                    </div>
                                                    <div data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                        <a href="{{ route('p5.project.edit', $project->id) }}"
                                                            class="btn btn-info btn-sm mt-1"><i
                                                                class="fas
                                                            fa-eye"></i></a>
                                                    </div>
                                                    @include('components.actions.delete-button', [
                                                        'route' => route('p5.project.destroy', $project->id),
                                                        'id' => $project->id,
                                                        'isPermanent' => true,
                                                        'withEdit' => false,
                                                        'withShow' => false,
                                                    ])
                                                </td>
                                            </tr>

                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $project->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        </div>
                                                        <form action="{{ route('p5.project.update', $project->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="name"
                                                                        class="col-sm-3 col-form-label">Name</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="name" name="name"
                                                                            placeholder="Name"
                                                                            value="{{ $project->name }}">
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
        <!--/. container-fluid -->
    </div>
@endsection



@section('footer')
    @include('layouts.main.footer')
@endsection

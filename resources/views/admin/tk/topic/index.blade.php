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
                                    <form action="{{ route('tk.topic.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="tk_element_id" class="col-sm-3 col-form-label">Element
                                                </label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" name="tk_element_id"
                                                        id="tk_element_id">
                                                        <option value="">-- Pilih Element --
                                                        </option>
                                                        @foreach ($data_element as $element)
                                                            <option value="{{ $element->id }}">
                                                                {{ $element->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 col-form-label">Topic
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Topic Name" value="{{ old('name') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="guru_id" class="col-sm-3 col-form-label">Guru</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select select2" name="guru_id">
                                                        <option value="">-- Pilih Guru --</option>
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
                            <div class="callout callout-info">
                                <form action="{{ route('tk.topic.create') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="tingkatan_id" class="col-sm-3 col-form-label">Tingkatan</label>
                                        <div class="col-sm-9">
                                            <select class="form-control form-select select2" name="tingkatan_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="">-- Pilih Tingkatan --</option>
                                                @foreach ($data_tingkatan as $tingkatan)
                                                    <option value="{{ $tingkatan->id }}"
                                                        {{ $tingkatan->id == $tingkatan_id ? 'selected' : '' }}>
                                                        {{ $tingkatan->nama_tingkatan }}
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Element</th>
                                            <th>Topic</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_topic as $topic)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $topic->element->name }}</td>
                                                <td>{{ $topic->name }}</td>
                                                <td class="text-center">
                                                    @include('components.actions.delete-button', [
                                                        'route' => route('tk.topic.destroy', $topic->id),
                                                        'id' => $topic->id,
                                                        'isPermanent' => true,
                                                        'withEdit' => true,
                                                        'withShow' => false,
                                                    ])
                                                </td>
                                            </tr>

                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $topic->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        </div>
                                                        <form action="{{ route('tk.topic.update', $topic->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="tk_element_id"
                                                                        class="col-sm-3 col-form-label">Element
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control form-select select2"
                                                                            name="tk_element_id" id="tk_element_id">
                                                                            <option value="">-- Pilih Element --
                                                                            </option>
                                                                            @foreach ($data_element as $element)
                                                                                <option value="{{ $element->id }}"
                                                                                    {{ $topic->tk_element_id == $element->id ? 'selected' : '' }}>
                                                                                    {{ $element->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="tahun_pelajaran"
                                                                        class="col-sm-3 col-form-label">Topic Name</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="name" name="name"
                                                                            placeholder="Topic Name"
                                                                            value="{{ $topic->name }}"">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="guru_id"
                                                                        class="col-sm-3 col-form-label">Guru</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control form-select select2"
                                                                            name="guru_id" id="guru_id">
                                                                            @foreach ($data_guru as $guru)
                                                                                <option value="{{ $guru->id }}"
                                                                                    {{ $topic->guru_id == $guru->id ? 'selected' : '' }}>
                                                                                    {{ $guru->karyawan->nama_lengkap }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-end">
                                                                <button type="button" class="btn btn-default"
                                                                    data-bs-dismiss="modal">Cancel</button>
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

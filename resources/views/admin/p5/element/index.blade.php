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
                                    <form action="{{ route('p5.element.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 col-form-label">Dimensi</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select" name="p5_dimensi_id">
                                                        <option value="">== Pilih Dimensi ==</option>
                                                        @foreach ($dataDimensi as $dimensi)
                                                            <option value="{{ $dimensi->id }}">
                                                                {{ $dimensi->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 col-form-label">Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Name" value="{{ old('name') }}">
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
                                            <th>Dimensi</th>
                                            <th>Element</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($dataElement as $element)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $element->dimensi->name }}</td>
                                                <td>{{ $element->name }}</td>
                                                <td class="text-center">
                                                    @include('components.actions.delete-button', [
                                                        'route' => route('p5.element.destroy', $element->id),
                                                        'id' => $element->id,
                                                        'isPermanent' => true,
                                                        'withEdit' => true,
                                                        'withShow' => false,
                                                    ])
                                                </td>
                                            </tr>

                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $element->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        </div>
                                                        <form action="{{ route('p5.element.update', $element->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="name"
                                                                        class="col-sm-3 col-form-label">Dimensi</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-select form-control"
                                                                            name="p5_dimensi_id" id="p5_dimensi_id">
                                                                            <option value="">== Pilih Dimensi ==
                                                                            </option>
                                                                            @foreach ($dataDimensi as $dimensi)
                                                                                <option value="{{ $dimensi->id }}"
                                                                                    {{ $dimensi->id == $element->p5_dimensi_id ? 'selected' : '' }}>
                                                                                    {{ $dimensi->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="name"
                                                                        class="col-sm-3 col-form-label">Name</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="name" name="name" placeholder="Name"
                                                                            value="{{ $element->name }}">
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
        <!--/. container-fluid -->
    </div>
@endsection



@section('footer')
    @include('layouts.main.footer')
@endsection

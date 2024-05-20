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
                                    <form action="{{ route('p5.subelement.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 col-form-label">Element</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select" name="p5_dimensi_id" readonly>
                                                        <option value="">== Pilih Element ==</option>
                                                        @foreach ($dataElement as $element)
                                                            <option value="{{ $element->id }}">
                                                                {{ $element->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 col-form-label">Element</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-select" name="p5_dimensi_id" readonly>
                                                        <option value="">== Pilih Element ==</option>
                                                        @foreach ($dataElement as $element)
                                                            <option value="{{ $element->id }}">
                                                                {{ $element->name }}
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
                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 col-form-label">Description</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="description"
                                                        name="description" placeholder="Description"
                                                        value="{{ old('description') }}">
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
                                            <th>Subelement</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($dataSubelement as $subelement)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $subelement->element->dimensi->name }}</td>
                                                <td>{{ $subelement->element->name }}</td>
                                                <td>{{ $subelement->name }}</td>
                                                <td>{{ $subelement->description }}</td>
                                                <td class="text-center">
                                                    @include('components.actions.delete-button', [
                                                        'route' => route('p5.subelement.destroy', $subelement->id),
                                                        'id' => $subelement->id,
                                                        'isPermanent' => true,
                                                        'withEdit' => true,
                                                        'withShow' => false,
                                                    ])
                                                </td>
                                            </tr>

                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $subelement->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        </div>
                                                        <form action="{{ route('p5.subelement.update', $subelement->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="name"
                                                                        class="col-sm-3 col-form-label">Element</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-select form-control"
                                                                            name="p5_dimensi_id" id="p5_dimensi_id">
                                                                            <option value="">== Pilih Element ==
                                                                            </option>
                                                                            @foreach ($dataElement as $element)
                                                                                <option value="{{ $element->id }}"
                                                                                    {{ $element->id == $element->p5_dimensi_id ? 'selected' : '' }}>
                                                                                    {{ $element->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="name"
                                                                        class="col-sm-3 col-form-label">Name</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="name" name="name"
                                                                            placeholder="Name"
                                                                            value="{{ $element->name }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="description"
                                                                        class="col-sm-3 col-form-label">Description</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="description" name="description"
                                                                            placeholder="Description"
                                                                            value="{{ $element->description }}">
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

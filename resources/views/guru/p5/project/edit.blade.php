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
                    'url' => $dashboard,
                    'active' => true,
                ],
                [
                    'title' => 'Manajemen P5BK',
                    'url' => route('guru.p5.project.index'),
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
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title">{{ $title }}</h3>
                            <div class="card-tools ms-auto d-flex gap-2 justify-content-center">
                                <div data-bs-toggle="tooltip"
                                    data-bs-original-title=" {{ isset($project) && $project->subelement_active_count > 0 ? 'Nilai' : 'Belum ada Subelemen Projek, tekan tombol Edit untuk menambahkan.' }}">
                                    <a href="{{ isset($project) && $project->subelement_active_count > 0 ? route('guru.p5.project.show', $project->id) : '#' }}"
                                        class="btn btn-success btn-sm {{ isset($project) && $project->subelement_active_count <= 0 ? ' disabled' : '' }}"
                                        role="button"
                                        aria-disabled="{{ isset($project) && $project->subelement_active_count <= 0 ? 'true' : 'false' }}">
                                        Nilai Project
                                    </a>
                                </div>
                                <div data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                    <a href="#" class="btn btn-primary btn-sm disabled">Edit Project</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">

                            <form action="{{ route('guru.p5.project.update', $project->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="kelas_id" value="{{ $project->kelas_id }}">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="guru_id" class="col-sm-3 col-form-label">Pembina Projek</label>
                                        <select name="guru_id" id="guru_id" class="form-control form-select select2">
                                            @foreach ($dataGuru as $guru)
                                                <option value="{{ $guru->id }}"
                                                    {{ $project->guru_id == $guru->id ? 'selected' : '' }}
                                                    {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                                    {{ $guru->karyawan->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-8">
                                        <label for="name" class="col-sm-3 col-form-label">Judul Projek</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $project->name) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="description" class="col-sm-3 col-form-label">Deskripsi Projek</label>
                                        <textarea class="form-control" name="description" id="description" cols="120" rows="5">{{ old('description', $project->description) }}</textarea>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-valign-middle ">
                                        <thead>
                                            <tr>
                                                <th>Active</th>
                                                <th>Dimensi</th>
                                                <th>Element</th>
                                                <th>Subelement</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            @foreach ($dataSubelement as $index => $subelement)
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="hidden" name="subelement_id[]"
                                                            value="{{ $subelement->id }}">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="has_active[{{ $index }}]"
                                                            {{ $subelement->has_active ? 'checked' : '' }}>
                                                    </td>
                                                    <td>{{ $subelement->element->dimensi->name }}</td>
                                                    <td>{{ $subelement->element->name }}</td>
                                                    <td>{{ $subelement->name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
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

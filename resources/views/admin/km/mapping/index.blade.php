@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.index')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            if (
                $user->hasAnyRole(['Teacher', 'Curriculum']) &&
                $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])
            ) {
                $dashboard = route('guru.dashboard');
            } elseif ($user->hasAnyRole(['Student']) && $user->hasAnyPermission(['student'])) {
                $dashboard = route('siswa.dashboard');
            } else {
                $dashboard = route('admin.dashboard');
            }
        @endphp
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
            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-list-ol"></i> {{ $title }}</h3>
                        </div>

                        <div class="card-body">

                            <form action="{{ route('km.mapping.store') }}" method="POST">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead class="bg-info">
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Mata Pelajaran</th>
                                                <th class="text-center">Kelompok</th>
                                                <th class="text-center">No Urut Raport</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            @foreach ($data_mapel as $mapel)
                                                <?php $no++; ?>
                                                <tr>
                                                    <td class="text-center">{{ $no }}</td>
                                                    <td>{{ $mapel->nama_mapel }}
                                                        <input type="hidden" name="mapel_id[]" value="{{ $mapel->id }}">
                                                    </td>
                                                    <td>
                                                        <select class="form-control form-select" name="kelompok[]"
                                                            style="width: 100%;" required>
                                                            <option value="">-- Pilih Kelompok Mapel-- </option>
                                                            <option value="A"
                                                                @if ($mapel->kelompok == 'A') selected @endif>Kelompok A
                                                            </option>
                                                            <option value="B"
                                                                @if ($mapel->kelompok == 'B') selected @endif>Kelompok B
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="nomor_urut[]"
                                                            value="{{ $mapel->nomor_urut }}" required>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-footer clearfix">
                                    <button type="submit" class="btn btn-success float-right">Simpan</button>
                                </div>
                        </div>
                        </form>
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

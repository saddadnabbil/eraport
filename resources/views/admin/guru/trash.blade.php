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
                    'url' => route('dashboard'),
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Full name</th>
                                            <th>NIP</th>
                                            <th>NUPTK</th>
                                            <th>Tempat Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($guruTrashed as $guru)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $guru->karyawan->nama_lengkap }} </td>
                                                <td>{{ $guru->nip }}</td>
                                                <td>{{ $guru->nuptk }}</td>
                                                <td>{{ $guru->tempat_lahir }}</td>
                                                <td>
                                                    @if ($guru->jenis_kelamin == 'L')
                                                        Male
                                                    @else
                                                        Female
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2">
                                                        @include('components.actions.restore-button', [
                                                            'route' => route('guru.restore', $guru->id),
                                                            'id' => $guru->id,
                                                            'method' => 'PATCH',
                                                        ])
                                                        @include('components.actions.delete-button', [
                                                            'route' => route('guru.permanent-delete', $guru->id),
                                                            'id' => $guru->id,
                                                            'isPermanent' => true,
                                                            'withEdit' => false,
                                                            'withShow' => false,
                                                        ])
                                                    </div>
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



@section('footer')
    @include('layouts.main.footer')
@endsection

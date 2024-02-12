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
            <div class="callout callout-info">
                <h5>Add, edit, and delete {{ $title }}</h5>
                <p>Please go through the Employee menu or click the button below.</p>
                <a href="{{ route('karyawan.index') }}" class="btn btn-primary text-white" style="text-decoration:none">
                    Employee</a>
            </div>

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
                                            <th>Employee Code</th>
                                            <th>Identity Card</th>
                                            <th>Number Phone</th>
                                            <th>Gender</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_guru as $guru)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $guru->karyawan->nama_lengkap }} </td>
                                                <td>{{ $guru->karyawan->kode_karyawan }}</td>
                                                <td>{{ $guru->karyawan->nik }}</td>
                                                <td>{{ $guru->karyawan->nomor_phone }}</td>
                                                <td>
                                                    @if ($guru->jenis_kelamin == 'L')
                                                        Male
                                                    @else
                                                        Female
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('karyawan.show', $guru->karyawan->id) }}"
                                                        class="btn btn-info btn-sm  mt-1"><i class="fas fa-eye"></i></a>
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

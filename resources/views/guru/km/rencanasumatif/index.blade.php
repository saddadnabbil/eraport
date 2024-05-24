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
                    'title' => $title,
                    'url' => '',
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
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Subject</th>
                                            <th>Class</th>
                                            <th>Jumlah Rencana Grading</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_rencana_penilaian as $penilaian)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $penilaian->mapel->nama_mapel }}</td>
                                                <td>{{ $penilaian->kelas->nama_kelas }}</td>
                                                <td>
                                                    @if ($penilaian->jumlah_rencana_penilaian == 0)
                                                        <span class="badge bg-danger">Belum ada Grading Plan</span>
                                                    @else
                                                        <span
                                                            class="badge bg-success"><b>{{ $penilaian->jumlah_rencana_penilaian }}</b>
                                                            penilaian</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($penilaian->jumlah_rencana_penilaian == 0)
                                                        <form
                                                            action="{{ route('guru.km.rencanasumatif.create', $penilaian->id) }}"
                                                            method="GET">
                                                            @csrf
                                                            <input type="hidden" name="pembelajaran_id"
                                                                value="{{ $penilaian->id }}">
                                                            <input type="hidden" name="jumlah_penilaian"
                                                                value="{{ $penilaian->jumlah_rencana_penilaian == 0 ? 3 : $penilaian->jumlah_rencana_penilaian }}">

                                                            <button type="submit" class="btn btn-sm btn-primary"><i
                                                                    class="{{ $penilaian->jumlah_rencana_penilaian == 0 ? 'fas fa-plus' : 'fas fa-pen' }}"></i></button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('guru.km.rencanasumatif.show', $penilaian->id) }}"
                                                            class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
                                                    @endif
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

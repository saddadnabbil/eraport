@extends('layouts.main.header')

@section('sidebar')
    @include('layouts.sidebar.walikelas')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            if (
                $user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) &&
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
                            <h3 class="card-title"><i class="fas fa-print"></i> {{ $title }}</h3>
                        </div>

                        <div class="card-body">

                            <div class="callout callout-info">
                                <form action="{{ route('walikelas.raportpts.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Term</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select" name="term_id" style="width: 100%;"
                                                required onchange="this.form.submit()">
                                                <option value="1" @if ($term->id == '1') selected @endif>1
                                                </option>
                                                <option value="2" @if ($term->id == '2') selected @endif>2
                                                </option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Semester</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select" name="semester_id" style="width: 100%;"
                                                required onchange="this.form.submit()">
                                                <option value="1" @if ($semester->id == '1') selected @endif>1
                                                </option>
                                                <option value="2" @if ($semester->id == '2') selected @endif>2
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="bg-info">
                                        <tr>
                                            <th class="text-center" style="width: 5%;">No</th>
                                            <th class="text-center" style="width: 5%;">NIS</th>
                                            <th class="text-center">Student Name</th>
                                            <th class="text-center" style="width: 5%;">L/P</th>
                                            <th class="text-center" style="width: 15%;">Raport Tengah Semester</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @if (!$data_anggota_kelas->isEmpty())
                                            @foreach ($data_anggota_kelas->sortBy('siswa.nama_lengkap') as $anggota_kelas)
                                                <?php $no++; ?>
                                                <tr>
                                                    <input type="hidden" name="anggota_kelas_id[]"
                                                        value="{{ $anggota_kelas->id }}">
                                                    <td class="text-center">{{ $no }}</td>
                                                    <td class="text-center">{{ $anggota_kelas->siswa->nis }}</td>
                                                    <td>{{ $anggota_kelas->siswa->nama_lengkap }}</td>
                                                    <td class="text-center">{{ $anggota_kelas->siswa->jenis_kelamin }}</td>
                                                    <td class="text-center">
                                                        <form
                                                            action="{{ route('walikelas.raportpts.show', $anggota_kelas->id) }}"
                                                            target="_black" method="GET">
                                                            @csrf
                                                            <input type="hidden" name="paper_size"
                                                                value="{{ $paper_size }}">
                                                            <input type="hidden" name="orientation"
                                                                value="{{ $orientation }}">
                                                            <input type="hidden" name="semester_id"
                                                                value="{{ $semester->id }}">
                                                            <input type="hidden" name="term_id"
                                                                value="{{ $term->id }}">
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-print"></i> Raport PTS
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center" colspan="12">Data not available.</td>
                                            </tr>
                                        @endif
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

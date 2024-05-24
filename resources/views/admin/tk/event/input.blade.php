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
                    'title' => 'Kehadiran Siswa',
                    'url' => route('km.kehadirantk.index'),
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
                            <h3 class="card-title"><i class="fas fa-user-check"></i> {{ $title }}</h3>
                        </div>
                        <form action="{{ route('rekapevent.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="bg-info">
                                            <tr>
                                                <th rowspan="2" colspan="1" class="text-center" style="width: 5%;">No
                                                </th>
                                                <th rowspan="2" colspan="1" class="text-center" style="width: 5%;">NIS
                                                </th>
                                                <th rowspan="2" colspan="1" class="text-center" style="width: 35%;">
                                                    Student Name</th>
                                                @if ($data_event->isEmpty())
                                                    <th class="text-center" colspan="1" style="width: 5%;">Event</th>
                                                @else
                                                    <th class="text-center" colspan="{{ count($data_event) }}"
                                                        style="width: 5%;">Event</th>
                                                @endif

                                            </tr>
                                            <tr>
                                                @if ($data_event->isEmpty())
                                                    <th class="text-center" style="width: 15%;">-</th>
                                                @else
                                                    @foreach ($data_event as $event)
                                                        <th class="text-center" style="width: 15%;">{{ $event->name }}</th>
                                                    @endforeach
                                                @endif

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
                                                        @if ($data_event->isEmpty())
                                                            <td class="text-center">-</td>
                                                        @else
                                                            @foreach ($data_event as $event)
                                                                <input type="hidden" name="tk_event_id[]"
                                                                    value="{{ $event->id }}">
                                                                <td>
                                                                    @if ($rekap_event->isEmpty() || $rekap_event == null)
                                                                        <select class="form-control select2 form-select"
                                                                            name="grade_event[]" id="grade_event">
                                                                            <option value="">-- Pilih Grade --
                                                                            </option>
                                                                            <option value="C">C</option>
                                                                            <option value="ME">ME</option>
                                                                            <option value="I">I</option>
                                                                            <option value="NI">NI</option>
                                                                        </select>
                                                                    @else
                                                                        @php
                                                                            $found = false;
                                                                        @endphp
                                                                        @foreach ($rekap_event as $rekap)
                                                                            @if ($rekap->tk_event_id == $event->id && $rekap->anggota_kelas_id == $anggota_kelas->id)
                                                                                @php
                                                                                    $found = true;
                                                                                @endphp
                                                                                <select
                                                                                    class="form-control select2 form-select"
                                                                                    name="grade_event[]" id="grade_event">
                                                                                    <option value="C"
                                                                                        {{ $rekap->grade == 'C' ? 'selected' : '' }}>
                                                                                        C</option>
                                                                                    <option value="ME"
                                                                                        {{ $rekap->grade == 'ME' ? 'selected' : '' }}>
                                                                                        ME</option>
                                                                                    <option value="I"
                                                                                        {{ $rekap->grade == 'I' ? 'selected' : '' }}>
                                                                                        I</option>
                                                                                    <option value="NI"
                                                                                        {{ $rekap->grade == 'NI' ? 'selected' : '' }}>
                                                                                        NI</option>
                                                                                </select>
                                                                            @endif
                                                                        @endforeach
                                                                        @if (!$found)
                                                                            <select class="form-control select2 form-select"
                                                                                name="grade_event[]" id="grade_event">
                                                                                <option value="">-- Pilih Grade --
                                                                                </option>
                                                                                <option value="C">C</option>
                                                                                <option value="ME">ME</option>
                                                                                <option value="I">I</option>
                                                                                <option value="NI">NI</option>
                                                                            </select>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        @endif
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
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary float-right ml-2">Simpan</button>
                                <a href="{{ route('rekapevent.index') }}" class="btn btn-default float-right">Batal</a>
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

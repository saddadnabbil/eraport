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
                    'url' => route('guru.dashboard'),
                    'active' => true,
                ],
                [
                    'title' => 'Timetable Teacher',
                    'url' => route('admin.jadwalmengajar.index'),
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => route('admin.jadwalmengajar.index'),
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
                    @foreach ($dataPembelajaran as $pembelajaran)
                        <div class="d-flex justify-content-end mb-2">
                            <a href="{{ route('guru.timeslot.index') }}" class="btn btn-primary btn-tool btn-sm">
                                <i class="fas fa-hammer  me-2"></i>Set Timeslot
                            </a>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title font-weight-medium">
                                    {{ $pembelajaran->mapel->nama_mapel }} -
                                    {{ $pembelajaran->guru->karyawan->nama_lengkap }}
                                </h3>
                                <div class="card-tools">
                                    <div class="d-flex justify-content-end gap-3">
                                        <div data-bs-toggle="tooltip" data-bs-original-title="Show">
                                            <a href="{{ route('admin.jadwalmengajar.show', $pembelajaran->id) }}"
                                                class="btn btn-tool btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                        <div data-bs-toggle="tooltip" title="Print" class="d-inline-block"
                                            class="d-inline-block">
                                            <a href="{{ route('admin.jadwalmengajar.print', $pembelajaran->id) }}"
                                                class="btn btn-tool btn-sm">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <form action="{{ route('admin.jadwalmengajar.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="guru_id" value="{{ $guru->id }}">
                                        <input type="hidden" name="mapel_id" value="{{ $pembelajaran->mapel_id }}">
                                        <div class="beautify-scrollbar">
                                            <table class="border w-100 my-4 table-auto">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center p-1 whitespace-nowrap">
                                                            <p class="text-center mb-0">Time</p>
                                                        </th>
                                                        @foreach ($dataWeekdays as $weekdays)
                                                            <th scope="col" class="border p-1 whitespace-nowrap">
                                                                <p class="text-center mb-0">
                                                                    {{ $weekdays }}
                                                                </p>
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($dataJadwalMengajarSlot->isEmpty())
                                                        <tr>
                                                            <td colspan="{{ count($dataWeekdays) + 1 }}"
                                                                class="text-center border p-3 ">
                                                                Data tidak tersedia</td>
                                                        </tr>
                                                    @else
                                                        @foreach ($dataJadwalMengajarSlot as $slot)
                                                            <tr>
                                                                <td scope="col" class="p-3 border">
                                                                    <p class="text-center">
                                                                        <strong>
                                                                            <p class="text-center">
                                                                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                                                                -
                                                                                {{ \Carbon\Carbon::parse($slot->stop_time)->format('H:i') }}
                                                                            </p>
                                                                        </strong>
                                                                    </p>
                                                                </td>
                                                                @if ($slot->keterangan == 1)
                                                                    @foreach ($dataWeekdays as $day => $weekdays)
                                                                        <td class="p-3 border ">
                                                                            <select
                                                                                name="kelas[{{ $pembelajaran->mapel_id }}][{{ $slot->id }}][{{ $weekdays }}]"
                                                                                class="form-control form-select select2">
                                                                                <option value="">-- select subject
                                                                                    --
                                                                                </option>
                                                                                @foreach ($dataKelas as $kelas)
                                                                                    <option value="{{ $kelas->id }}"
                                                                                        @if (isset($selected[$pembelajaran->mapel_id][$slot->id][$weekdays]) &&
                                                                                                $selected[$pembelajaran->mapel_id][$slot->id][$weekdays] == $kelas->id) selected @endif>
                                                                                        {{ $kelas->nama_kelas }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                    @endforeach
                                                                @elseif ($slot->keterangan == 2)
                                                                    <td colspan="{{ count($dataWeekdays) }}"
                                                                        class="border text-center p-3 bg-success">
                                                                        <p class="text-center">
                                                                            <strong>
                                                                                Homeroom - Recess
                                                                            </strong>
                                                                        </p>
                                                                    </td>
                                                                @elseif ($slot->keterangan == 3)
                                                                    <td colspan="{{ count($dataWeekdays) }}"
                                                                        class="border text-center p-3 bg-success">
                                                                        <p class="text-center">
                                                                            <strong>
                                                                                Mealtime
                                                                            </strong>
                                                                        </p>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>

                                        @if (!$dataJadwalMengajarSlot->isEmpty())
                                            <div class="d-flex justify-content-start">
                                                <button type="submit" class="btn btn-primary rounded">Save</button>
                                            </div>
                                        @endif

                                    </form>
                                </div>

                            </div>
                        </div>
                        <!-- /.card -->
                    @endforeach


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

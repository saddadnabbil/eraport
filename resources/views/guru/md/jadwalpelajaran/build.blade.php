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
                    'title' => 'Timetable',
                    'url' => route('guru.jadwalpelajaran.index'),
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => route('guru.jadwalpelajaran.index'),
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
                            <div class="card-tools">
                                <div class="d-flex justify-content-end gap-3">
                                    <div data-bs-toggle="tooltip" data-bs-original-title="Set Timeslot">
                                        <a href="{{ route('guru.timeslot.index') }}" class="btn btn-tool btn-sm">
                                            <i class="fas fa-hammer"></i>
                                        </a>
                                    </div>
                                    <div data-bs-toggle="tooltip" data-bs-original-title="Show">
                                        <a href="{{ route('guru.jadwalpelajaran.show', $kelas->id) }}"
                                            class="btn btn-tool btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                    <div data-bs-toggle="tooltip" title="Print" class="d-inline-block"
                                        class="d-inline-block">
                                        <a href="{{ route('guru.jadwalpelajaran.print', $kelas->id) }}"
                                            class="btn btn-tool btn-sm">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="{{ route('guru.jadwalpelajaran.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
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
                                                @if ($dataJadwalPelajaranSlot->isEmpty())
                                                    <tr>
                                                        <td colspan="{{ count($dataWeekdays) + 1 }}"
                                                            class="text-center border p-3 ">
                                                            Data not available</td>
                                                    </tr>
                                                @else
                                                    @foreach ($dataJadwalPelajaranSlot as $slot)
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
                                                                            name="mapel[{{ $slot->id }}][{{ $weekdays }}]"
                                                                            class="form-control form-select">
                                                                            <option value="">-- select subject --
                                                                            </option>
                                                                            @foreach ($dataMapel as $mapel)
                                                                                <option value="{{ $mapel->id }}"
                                                                                    @if (isset($selected[$slot->id][$weekdays]) && $selected[$slot->id][$weekdays] == $mapel->id) selected @endif>
                                                                                    {{ $mapel->nama_mapel }}
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

                                    @if (!$dataJadwalPelajaranSlot->isEmpty())
                                        <div class="d-flex justify-content-start">
                                            <button type="submit" class="btn btn-primary rounded">Save</button>
                                        </div>
                                    @endif

                                </form>
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

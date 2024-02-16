@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.admin')
@endsection

@php
    function calculateRowspan($selected, $index, $day)
    {
        $rowspan = 1;

        // Check if the previous slot has the same value for the specified day
        if ($index > 0 && $selected[$index][$day] == $selected[$index - 1][$day]) {
            $rowspan = 0;
        }

        // Check if the next slot has the same value for the specified day
        if ($index < count($selected) - 1 && $selected[$index][$day] == $selected[$index + 1][$day]) {
            $rowspan = 0;
        }

        // Find the number of consecutive rows with the same value for the specified day
        for ($i = $index + 1; $i < count($selected); $i++) {
            if ($selected[$i][$day] == $selected[$i - 1][$day]) {
                $rowspan++;
            } else {
                break;
            }
        }

        return $rowspan;
    }
@endphp

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
                    'title' => 'Timetable',
                    'url' => route('jadwalpelajaran.index'),
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => route('statuskaryawan.index'),
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
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
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
                                                        class="text-center border p-4 ">
                                                        Data tidak tersedia</td>
                                                </tr>
                                            @else
                                                {{-- @php
                                                    $rowspanCounts = [];

                                                    foreach ($selected as $slotId => $selectedDays) {
                                                        foreach ($selectedDays as $day => $value) {
                                                            if (!isset($rowspanCounts[$day])) {
                                                                $rowspanCounts[$day] = 1;
                                                            } else {
                                                                $rowspanCounts[$day]++;
                                                            }
                                                        }
                                                    }
                                                @endphp --}}
                                                @php
                                                    $skippedCells = [];
                                                @endphp

                                                @foreach ($dataJadwalPelajaranSlot as $index => $slot)
                                                    <tr>
                                                        <td scope="col" rowspan="" class="p-4 border">
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
                                                                @php
                                                                    $rowspan = 1;
                                                                    for ($i = $index + 1; $i < count($dataJadwalPelajaranSlot); $i++) {
                                                                        if (isset($selected[$dataJadwalPelajaranSlot[$i]->id][$weekdays])) {
                                                                            if (!isset($skippedCells[$i])) {
                                                                                $skippedCells[$i] = [];
                                                                            }
                                                                            if (!isset($skippedCells[$i][$weekdays])) {
                                                                                $skippedCells[$i][$weekdays] = false;
                                                                            }

                                                                            if ($skippedCells[$i][$weekdays]) {
                                                                                continue;
                                                                            }

                                                                            if ($selected[$dataJadwalPelajaranSlot[$i]->id][$weekdays] != $selected[$slot->id][$weekdays] || ($selected[$dataJadwalPelajaranSlot[$i]->id][$weekdays] == $selected[$slot->id][$weekdays] && $dataJadwalPelajaranSlot[$i]->id == $slot->id && $weekdays == $day)) {
                                                                                break;
                                                                            }
                                                                            $rowspan++;
                                                                            // Add the skipped cells to the list
                                                                            for ($j = $index + 1; $j < $index + $rowspan; $j++) {
                                                                                $skippedCells[$j][$weekdays] = true;
                                                                            }
                                                                        }
                                                                    }
                                                                @endphp
                                                                @php
                                                                    $isPrimary = isset($selected[$slot->id][$weekdays]) && $selected[$slot->id][$weekdays] && !in_array($index, $skippedCells);
                                                                @endphp
                                                                <td class="p-4 border{{ $isPrimary ? ' bg-primary' : '' }}"
                                                                    rowspan="{{ $rowspan }}">
                                                                    @if (!in_array($index, $skippedCells))
                                                                        @foreach ($dataMapel as $mapel)
                                                                            @if (isset($selected[$slot->id][$weekdays]) && $selected[$slot->id][$weekdays] == $mapel->id)
                                                                                <div class=" text-center">
                                                                                    {{ $mapel->nama_mapel }}</div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
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

@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.index')
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
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Print" class="d-inline-block" class="d-inline-block">
                                    <a href="{{ route('jadwalmengajar.print', $kelas->id) }}" class="btn btn-tool btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-center mt-3 text-body">
                                <h3><strong>{{ strtoupper($kelas->nama_kelas) }} </strong></h3>
                            </div>
                            <div class="table-responsive">
                                <div class="beautify-scrollbar">
                                    <table class="border w-100 my-4 table-auto">
                                        <thead>
                                            <tr>
                                                <th class="text-center p-3 whitespace-nowrap"
                                                    style="background-color: #93acd457; color: #212529">
                                                    <p class="text-center mb-0">Time</p>
                                                </th>
                                                @foreach ($dataWeekdays as $weekdays)
                                                    <th scope="col" class="border p-3 whitespace-nowrap"
                                                        style="background-color: #93acd457; color: #212529">
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
                                                        Data tidak tersedia</td>
                                                </tr>
                                            @else
                                                @php
                                                    $skippedCells = [];
                                                @endphp
                                                @foreach ($dataJadwalPelajaranSlot as $index => $slot)
                                                    <tr>
                                                        <td scope="col" rowspan="" class="p-3 border">
                                                            <p class="text-center text-body">
                                                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($slot->stop_time)->format('H:i') }}
                                                            </p>
                                                        </td>
                                                        @if ($slot->keterangan == 1)
                                                            @foreach ($dataWeekdays as $day => $weekdays)
                                                                @php
                                                                    $rowspan = 1;
                                                                @endphp
                                                                @for ($i = $index + 1; $i < count($dataJadwalPelajaranSlot); $i++)
                                                                    @if (isset($selected[$dataJadwalPelajaranSlot[$i]->id][$weekdays]))
                                                                        @if ($selected[$dataJadwalPelajaranSlot[$i]->id][$weekdays] != $selected[$slot->id][$weekdays])
                                                                        @break
                                                                    @endif
                                                                    @php
                                                                        $rowspan++;
                                                                        // Add the skipped cells to the list
                                                                        $skippedCells[] = [
                                                                            'slot_id' =>
                                                                                $dataJadwalPelajaranSlot[$i]->id,
                                                                            'days' => $weekdays,
                                                                            'index' => $i,
                                                                        ];
                                                                    @endphp
                                                                @endif
                                                            @endfor
                                                            @php
                                                                $isPrimary =
                                                                    isset($selected[$slot->id][$weekdays]) &&
                                                                    $selected[$slot->id][$weekdays] &&
                                                                    !in_array(
                                                                        [
                                                                            'slot_id' => $slot->id,
                                                                            'days' => $weekdays,
                                                                            'index' => $index,
                                                                        ],
                                                                        $skippedCells,
                                                                    );
                                                            @endphp
                                                            @if (!in_array(['slot_id' => $slot->id, 'days' => $weekdays, 'index' => $index], $skippedCells))
                                                                <td class="p-3 border"
                                                                    style="{{ $isPrimary ? ' background-color: 	#a7d7ff7d; color: #212529' : '' }}"
                                                                    rowspan="{{ $rowspan }}">
                                                                    @foreach ($dataMapel as $mapel)
                                                                        @if (isset($selected[$slot->id][$weekdays]) && $selected[$slot->id][$weekdays] == $mapel->id)
                                                                            <div class="text-center">
                                                                                {{ $mapel->nama_mapel }}
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <td colspan="{{ count($dataWeekdays) }}"
                                                            class="border text-center p-3 text-body">
                                                            <strong>
                                                                <i>
                                                                    @if ($slot->keterangan == 2)
                                                                        Homeroom - Recess
                                                                    @elseif ($slot->keterangan == 3)
                                                                        Mealtime
                                                                    @else
                                                                        Other
                                                                    @endif
                                                                </i>
                                                            </strong>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach

                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <table style="margin: 120px auto 20px; text-align: center;">
                                <tr>
                                    <td style="padding-right: 20px;">
                                        <img src="{{ asset('assets/dist/img/merdeka-belajar.png') }}"
                                            alt="Merdeka Belajar" style="max-width: 100%; height: 100px;">
                                    </td>
                                    <td style="padding-left: 20px;">
                                        <img src="{{ asset('assets/dist/img/pearson-edexcel.png') }}"
                                            alt="Pearson Edexcel" style="max-width: 100%; height: 100px;">
                                    </td>
                                </tr>
                            </table>
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

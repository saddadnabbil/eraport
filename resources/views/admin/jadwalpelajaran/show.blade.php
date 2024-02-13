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
                                                <th class="text-center p-2 w-60 whitespace-nowrap">
                                                    <p class="text-center mb-0">Time</p>
                                                </th>
                                                @foreach ($dataWeekdays as $weekdays)
                                                    <th scope="col" class="border p-2   w-60 whitespace-nowrap">
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
                                                        class="text-center p-4 border">
                                                        Data tidak tersedia</td>
                                                </tr>
                                            @else
                                                @foreach ($dataJadwalPelajaranSlot as $slot)
                                                    <tr>
                                                        <td scope="col" class="p-4 border">
                                                            <p class="">
                                                                <strong>
                                                                    <p>{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                                                        -
                                                                        {{ \Carbon\Carbon::parse($slot->stop_time)->format('H:i') }}
                                                                    </p>
                                                                </strong>
                                                            </p>
                                                        </td>
                                                        @foreach ($dataWeekdays as $day => $weekdays)
                                                            <td class="p-4 border w-60">
                                                                <select
                                                                    name="mapel[{{ $slot->id }}][{{ $weekdays }}]"
                                                                    class="form-control form-select" disabled>
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

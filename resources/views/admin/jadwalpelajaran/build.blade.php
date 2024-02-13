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
                    'title' => 'Timetable',
                    'url' => route('jadwalpelajaran.index'),
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => route('jadwalpelajaran.index'),
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
                                <form action="{{ route('jadwalpelajaran.manage') }}" method="POST">
                                    @csrf

                                    <div class="beautify-scrollbar">
                                        <table class="border w-100 my-4 table-auto">
                                            <thead>
                                                <tr>
                                                    <th class="text-center p-4 w-60 whitespace-nowrap">
                                                        <p>Time</p>
                                                    </th>
                                                    @foreach ($dataWeekdays as $weekdays)
                                                        <th scope="col" class="border p-4 w-60 whitespace-nowrap">
                                                            <p class="text-center ">
                                                                {{ $weekdays }}
                                                            </p>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                                            {{-- @dd($selected)
                                                            @dd($selected[$slot->id][$weekdays]) --}}

                                                            <td class="p-4 border w-60">
                                                                <select
                                                                    name="mapel[{{ $slot->id }}][{{ $weekdays }}]"
                                                                    class="form-control form-select">
                                                                    <option value="">-- select subject --</option>
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
                                            </tbody>
                                        </table>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Time Slot</h3>
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Add Time Slot" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-tambah">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal tambah  -->
                        <div class="modal fade" id="modal-tambah">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Time Slot {{ $title }}</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                        </button>
                                    </div>
                                    <form action="{{ route('jadwalpelajaran.timeSlot') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="jadwal_pelajaran_id"
                                            value="{{ $jadwalPelajaran->id }}">
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="start_time" class="col-sm-3 col-form-label">Start Time</label>
                                                <div class="col-sm-9">
                                                    <input type="time" class="form-control" id="start_time"
                                                        name="start_time" placeholder="Timetable Name"
                                                        value="{{ old('start_time') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="stop_time" class="col-sm-3 col-form-label">Stop Time</label>
                                                <div class="col-sm-9">
                                                    <input type="time" class="form-control" id="stop_time"
                                                        name="stop_time" placeholder="Timetable Name"
                                                        value="{{ old('stop_time') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-end">
                                            <button type="button" class="btn btn-default"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal tambah -->

                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="table" class="table table-striped table-valign-middle ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Timeslot</th>
                                            <th>Start Time</th>
                                            <th>Stop Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($dataJadwalPelajaranSlot as $slot)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($slot->stop_time)->format('H:i') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}</td>
                                                <td class="text-center">
                                                    @include('components.actions.delete-button', [
                                                        'route' => route(
                                                            'jadwalpelajaran.deleteTimeSlot',
                                                            $slot->id),
                                                        'id' => $slot->id,
                                                        'isPermanent' => true,
                                                        'withEdit' => false,
                                                        'withShow' => false,
                                                    ])
                                                </td>
                                            </tr>

                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $slot->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('jadwalpelajaran.update', $jadwalPelajaran->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="nama"
                                                                        class="col-sm-3 col-form-label">Timetable
                                                                        Name</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="nama" name="nama"
                                                                            placeholder="Timetable Name"
                                                                            value="{{ $jadwalPelajaran->nama }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-end">
                                                                <button type="button" class="btn btn-default"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal edit -->
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
        <!--/. container-fluid -->
    </div>
@endsection



@section('footer')
    @include('layouts.main.footer')
@endsection

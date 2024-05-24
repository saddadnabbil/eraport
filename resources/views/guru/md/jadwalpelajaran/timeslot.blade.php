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

            {{-- data table --}}
            <!-- ./row -->
            <div class="row">
                <div class="col-12">
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
                                    <form action="{{ route('guru.timeslot.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="tapel_id" value="{{ $tapel->id }}">
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
                                            <div class="form-group row">
                                                <label for="stop_time" class="col-sm-3 col-form-label">Note</label>
                                                <div class="col-sm-9">
                                                    <select name="keterangan" id="keterangan"
                                                        class="form-control form-select">
                                                        <option value="">-- Pilih Keterangan --</option>
                                                        <option value="1"
                                                            @if (old('keterangan') == '1') selected @endif>Lesson Hours
                                                        </option>
                                                        <option value="2"
                                                            @if (old('keterangan') == '2') selected @endif>Recess
                                                        </option>
                                                        <option value="3"
                                                            @if (old('keterangan') == '3') selected @endif>Mealtime
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-end">
                                            <button type="button" class="btn btn-default"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
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
                                            <th>Note</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @if ($dataJadwalPelajaranSlot->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center border p-3">
                                                    Data not available</td>
                                            </tr>
                                        @else
                                            @foreach ($dataJadwalPelajaranSlot as $slot)
                                                <?php $no++; ?>
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                                                        {{ \Carbon\Carbon::parse($slot->stop_time)->format('H:i') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($slot->stop_time)->format('H:i') }}</td>
                                                    <td>
                                                        {{ $slot->keterangan == '1' ? 'Lesson Hours' : ($slot->keterangan == '2' ? 'Recess' : 'Mealtime') }}
                                                    </td>
                                                    <td class="text-center">
                                                        @include('components.actions.delete-button', [
                                                            'route' => route('guru.timeslot.destroy', $slot->id),
                                                            'id' => $slot->id,
                                                            'isPermanent' => true,
                                                            'withEdit' => true,
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

                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-hidden="true"></button>
                                                            </div>
                                                            <form action="{{ route('guru.timeslot.update', $slot->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="form-group row">
                                                                        <label for="start_time"
                                                                            class="col-sm-3 col-form-label">Start
                                                                            Time</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="time" class="form-control"
                                                                                id="start_time" name="start_time"
                                                                                placeholder="Timetable Name"
                                                                                value="{{ $slot->start_time }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="stop_time"
                                                                            class="col-sm-3 col-form-label">Stop
                                                                            Time</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="time" class="form-control"
                                                                                id="stop_time" name="stop_time"
                                                                                placeholder="Timetable Name"
                                                                                value="{{ $slot->stop_time }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="stop_time"
                                                                            class="col-sm-3 col-form-label">Note</label>
                                                                        <div class="col-sm-9">
                                                                            <select name="keterangan" id="keterangan"
                                                                                class="form-control form-select">
                                                                                <option value="">-- Pilih Keterangan
                                                                                    --</option>
                                                                                <option value="1"
                                                                                    @if ($slot->keterangan == '1') selected @endif>
                                                                                    Lesson Hours
                                                                                </option>
                                                                                <option value="2"
                                                                                    @if ($slot->keterangan == '2') selected @endif>
                                                                                    Recess
                                                                                </option>
                                                                                <option value="3"
                                                                                    @if ($slot->keterangan == '3') selected @endif>
                                                                                    Mealtime
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-end">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal edit -->
                                            @endforeach
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
        <!--/. container-fluid -->
    </div>
@endsection



@section('footer')
    @include('layouts.main.footer')
@endsection

@extends('layouts.main.header')

@section('sidebar')
    @include('layouts.sidebar.siswa')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            $dashboard = route('siswa.dashboard');
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
                            <h3 class="card-title"> {{ $title }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-info">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        Full name
                                    </div>
                                    <div class="col-sm-9">
                                        : {{ $siswa->nama_lengkap }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        Kelas
                                    </div>
                                    <div class="col-sm-9">
                                        : {{ $siswa->kelas->nama_kelas }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        Nomor Induk / NISN
                                    </div>
                                    <div class="col-sm-9">
                                        : {{ $siswa->nis }} / {{ $siswa->nisn }}
                                    </div>
                                </div>
                            </div>
                            @if ($tingkatan->id != 1 && $tingkatan->id != 2 && $tingkatan->id && 3)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="bg-info">
                                            <tr>
                                                <th class="text-center" rowspan="2" style="width: 5%;">No</th>
                                                <th class="text-center" rowspan="2" style="width: 28%;">Subject</th>
                                                <th class="text-center" rowspan="2" style="width: 7%;">KKM</th>
                                                <th class="text-center" colspan="2" style="width: 15%;">Sumatif</th>
                                                <th class="text-center" colspan="2" style="width: 15%;">Formatif</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center" style="width: 7%;">Nilai</th>
                                                <th class="text-center" style="width: 8%;">Predikat</th>
                                                <th class="text-center" style="width: 7%;">Nilai</th>
                                                <th class="text-center" style="width: 8%;">Predikat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            @foreach ($data_pembelajaran->sortBy('mapel.nama_mapel') as $pembelajaran)
                                                <?php $no++; ?>
                                                <tr>
                                                    <td class="text-center">{{ $no }}</td>
                                                    <td>{{ $pembelajaran->mapel->nama_mapel }}</td>
                                                    @if (!is_null($pembelajaran->nilai))
                                                        <td class="text-center">{{ $pembelajaran->nilai->kkm }}</td>
                                                        <td class="text-center">{{ $pembelajaran->nilai->nilai_sumatif }}
                                                        </td>
                                                        <td class="text-center">{{ $pembelajaran->nilai->predikat_sumatif }}
                                                        </td>
                                                        <td class="text-center">{{ $pembelajaran->nilai->nilai_formatif }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $pembelajaran->nilai->predikat_formatif }}
                                                        </td>
                                                    @else
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="col-12">
                                    <div class="table-responsive p-2">
                                        <table class="table table-bordered">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th style="width: 90%" class="text-center">AREA OF LEARNING &
                                                        DEVELOPMENT </th>
                                                    <th style="width: 10%">ACHIEVEMENT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataTkElements as $element)
                                                    <tr
                                                        style="background-color: rgba(148, 148, 148, 0.384); text-align: center; font-weight: bold;">
                                                        <td colspan="2">{{ $element->name }}</td>
                                                    </tr>
                                                    @foreach ($dataTkTopics->where('tk_element_id', $element->id) as $topic)
                                                        <tr
                                                            style="background-color: rgba(148, 148, 148, 0.185); text-transform: uppercase; font-weight: bold;">
                                                            <td colspan="2">{{ $topic->name }}</td>
                                                        </tr>
                                                        @foreach ($dataTkSubtopics->where('tk_topic_id', $topic->id) as $subtopic)
                                                            <tr
                                                                style="background-color: rgba(231, 231, 231, 0.384); font-weight: bold;">
                                                                <td colspan="2"><i>{{ $subtopic->name }}</i></td>
                                                            </tr>
                                                            @foreach ($dataTkPoints->where('tk_subtopic_id', $subtopic->id) as $point)
                                                                @php
                                                                    $achivement = $dataAchivements
                                                                        ->where('tk_point_id', $point->id)
                                                                        ->where('anggota_kelas_id', $anggotaKelas->id)
                                                                        ->first();
                                                                @endphp
                                                                @if ($achivement)
                                                                    @foreach ($dataAchivements->where('tk_point_id', $point->id)->where('anggota_kelas_id', $anggotaKelas->id) as $achivement)
                                                                        <input disabled type="hidden" name="tk_point_id[]"
                                                                            value="{{ $point->id }}">
                                                                        <tr>
                                                                            <td>{{ $point->name }}</td>
                                                                            <td>
                                                                                <select disabled class="form-control"
                                                                                    name="achivement[]">
                                                                                    <option value="">
                                                                                    </option>
                                                                                    <option value="C"
                                                                                        {{ $achivement && $achivement->achivement == 'C' ? 'selected' : '' }}>
                                                                                        C</option>
                                                                                    <option value="ME"
                                                                                        {{ $achivement && $achivement->achivement == 'ME' ? 'selected' : '' }}>
                                                                                        ME</option>
                                                                                    <option value="I"
                                                                                        {{ $achivement && $achivement->achivement == 'I' ? 'selected' : '' }}>
                                                                                        I</option>
                                                                                    <option value="NI"
                                                                                        {{ $achivement && $achivement->achivement == 'NI' ? 'selected' : '' }}>
                                                                                        NI</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td>{{ $point->name }}</td>
                                                                        <td>
                                                                            <input disabled type="hidden"
                                                                                name="tk_point_id[]"
                                                                                value="{{ $point->id }}">
                                                                            <select disabled class="form-control"
                                                                                name="achivement[]">
                                                                                <option value="">
                                                                                </option>
                                                                                <option value="C">
                                                                                    C</option>
                                                                                <option value="ME">
                                                                                    ME</option>
                                                                                <option value="I">
                                                                                    I</option>
                                                                                <option value="NI">
                                                                                    NI</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endforeach

                                                        @foreach ($dataTkPoints->where('tk_topic_id', $topic->id)->where('tk_subtopic_id', null) as $point)
                                                            @if ($point->tk_subtopic_id == null && $point->tk_topic_id == $topic->id)
                                                                @php
                                                                    $achivement = $dataAchivements
                                                                        ->where('tk_point_id', $point->id)
                                                                        ->where('anggota_kelas_id', $anggotaKelas->id)
                                                                        ->first();
                                                                @endphp
                                                                @if ($achivement)
                                                                    @foreach ($dataAchivements->where('tk_point_id', $point->id)->where('anggota_kelas_id', $anggotaKelas->id) as $achivement)
                                                                        <input disabled type="hidden" name="tk_point_id[]"
                                                                            value="{{ $point->id }}">
                                                                        <tr>
                                                                            <td>{{ $point->name }}</td>
                                                                            <td>
                                                                                <select disabled class="form-control"
                                                                                    name="achivement[]">
                                                                                    <option value="">
                                                                                    </option>
                                                                                    <option value="C"
                                                                                        {{ $achivement && $achivement->achivement == 'C' ? 'selected' : '' }}>
                                                                                        C</option>
                                                                                    <option value="ME"
                                                                                        {{ $achivement && $achivement->achivement == 'ME' ? 'selected' : '' }}>
                                                                                        ME</option>
                                                                                    <option value="I"
                                                                                        {{ $achivement && $achivement->achivement == 'I' ? 'selected' : '' }}>
                                                                                        I</option>
                                                                                    <option value="NI"
                                                                                        {{ $achivement && $achivement->achivement == 'NI' ? 'selected' : '' }}>
                                                                                        NI</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    @php
                                                                        $achivement = $dataAchivements
                                                                            ->where('tk_point_id', $point->id)
                                                                            ->where(
                                                                                'anggota_kelas_id',
                                                                                $anggotaKelas->id,
                                                                            )
                                                                            ->first();
                                                                    @endphp
                                                                    @if ($achivement)
                                                                        @foreach ($dataAchivements->where('tk_point_id', $point->id)->where('anggota_kelas_id', $anggotaKelas->id) as $achivement)
                                                                            <input disabled type="hidden"
                                                                                name="tk_point_id[]"
                                                                                value="{{ $point->id }}">
                                                                            <tr>
                                                                                <td>{{ $point->name }}</td>
                                                                                <td>
                                                                                    <select disabled class="form-control"
                                                                                        name="achivement[]">
                                                                                        <option value="">
                                                                                        </option>
                                                                                        <option value="C"
                                                                                            {{ $achivement && $achivement->achivement == 'C' ? 'selected' : '' }}>
                                                                                            C</option>
                                                                                        <option value="ME"
                                                                                            {{ $achivement && $achivement->achivement == 'ME' ? 'selected' : '' }}>
                                                                                            ME</option>
                                                                                        <option value="I"
                                                                                            {{ $achivement && $achivement->achivement == 'I' ? 'selected' : '' }}>
                                                                                            I</option>
                                                                                        <option value="NI"
                                                                                            {{ $achivement && $achivement->achivement == 'NI' ? 'selected' : '' }}>
                                                                                            NI</option>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td>{{ $point->name }}</td>
                                                                            <td>
                                                                                <input disabled type="hidden"
                                                                                    name="tk_point_id[]"
                                                                                    value="{{ $point->id }}">
                                                                                <select disabled class="form-control"
                                                                                    name="achivement[]">
                                                                                    <option value="">
                                                                                    </option>
                                                                                    <option value="C">
                                                                                        C</option>
                                                                                    <option value="ME">
                                                                                        ME</option>
                                                                                    <option value="I">
                                                                                        I</option>
                                                                                    <option value="NI">
                                                                                        NI</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endif
                                                            @elseif ($point->tk_subtopic_id == $subtopic->id)
                                                                <tr>
                                                                    <td>{{ $point->name }}</td>
                                                                    <td>
                                                                        <input disabled type="hidden"
                                                                            name="tk_point_id[]"
                                                                            value="{{ $point->id }}">
                                                                        <select disabled class="form-control"
                                                                            name="achivement[]" id="achivement">
                                                                            <option value="">

                                                                            </option>
                                                                            <option value="C">
                                                                                C</option>
                                                                            <option value="ME">
                                                                                ME</option>
                                                                            <option value="I">
                                                                                I</option>
                                                                            <option value="NI">NI</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                                <!-- EVENTS -->
                                                <tr
                                                    style="background-color: rgba(148, 148, 148, 0.384); text-align: center; font-weight: bold;">
                                                    <td colspan="2">EVENTS</td>
                                                </tr>
                                                @foreach ($dataEvents as $event)
                                                    <tr>
                                                        <td>{{ $event->name }}</td>
                                                        <td>
                                                            @forelse ($dataAchivementEvents->where('anggota_kelas_id', $anggotaKelas->id) as $achivementEvent)
                                                                @if ($achivementEvent->tk_event_id == $event->id)
                                                                    <input disabled type="hidden" name="tk_event_id[]"
                                                                        value="{{ $event->id }}">
                                                                    <select disabled class="form-control"
                                                                        name="achivement_event[]" id="achivement_event">
                                                                        <option value="">

                                                                        </option>
                                                                        <option value="C"
                                                                            @if ($achivementEvent->achivement_event == 'C') selected @endif>
                                                                            C</option>
                                                                        <option value="ME"
                                                                            @if ($achivementEvent->achivement_event == 'ME') selected @endif>
                                                                            ME</option>
                                                                        <option value="I"
                                                                            @if ($achivementEvent->achivement_event == 'I') selected @endif>
                                                                            I</option>
                                                                        <option value="NI"
                                                                            @if ($achivementEvent->achivement_event == 'NI') selected @endif>
                                                                            NI</option>
                                                                    </select>
                                                                @else
                                                                    <input disabled type="hidden" name="tk_event_id[]"
                                                                        value="{{ $event->id }}">
                                                                    <select disabled class="form-control"
                                                                        name="achivement_event[]" id="achivement_event">
                                                                        <option value="">

                                                                        </option>
                                                                        <option value="C">
                                                                            C</option>
                                                                        <option value="ME">
                                                                            ME</option>
                                                                        <option value="I">
                                                                            I</option>
                                                                        <option value="NI">
                                                                            NI</option>
                                                                    </select>
                                                                @endif
                                                            @empty
                                                                <input disabled type="hidden" name="tk_event_id[]"
                                                                    value="{{ $event->id }}">
                                                                <select disabled class="form-control"
                                                                    name="achivement_event[]" id="achivement_event">
                                                                    <option value="">

                                                                    </option>
                                                                    <option value="C">
                                                                        C</option>
                                                                    <option value="ME">
                                                                        ME</option>
                                                                    <option value="I">
                                                                        I</option>
                                                                    <option value="NI">
                                                                        NI</option>
                                                                </select>
                                                            @endforelse
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <!-- ATTENDANCE -->
                                                <tr
                                                    style="background-color: rgba(148, 148, 148, 0.384); text-align: center; font-weight: bold;">
                                                    <td colspan="2">ATTENDANCE</td>
                                                </tr>
                                                <tr>
                                                    <td>No. of School Days</td>
                                                    <td><input disabled type="number" class="form-control"
                                                            name="no_school_days"
                                                            value="{{ isset($dataAttendance) && $dataAttendance->no_school_days ? $dataAttendance->no_school_days : '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Days Attended</td>
                                                    <td><input disabled type="number" class="form-control"
                                                            name="days_attended"
                                                            value="{{ isset($dataAttendance) && $dataAttendance->days_attended ? $dataAttendance->days_attended : '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Days Absent</td>
                                                    <td><input disabled type="number" class="form-control"
                                                            name="days_absent"
                                                            value="{{ isset($dataAttendance) && $dataAttendance->days_absent ? $dataAttendance->days_absent : '' }}">
                                                    </td>
                                                </tr>

                                                <!-- CATATAN WALIKELAS -->
                                                <tr
                                                    style="background-color: rgba(148, 148, 148, 0.384); text-align: center; font-weight: bold;">
                                                    <td colspan="2">CATATAN WALIKELAS</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <textarea class="form-control" name="catatan_wali_kelas" rows="3" minlength="30" maxlength="200"
                                                            oninvalid="this.setCustomValidity('Catatan harus berisi antara 20 s/d 100 karekter')"
                                                            oninput="setCustomValidity('')" disabled>{{ isset($dataCatatanWalikelas) && $dataCatatanWalikelas->catatan ? $dataCatatanWalikelas->catatan : '' }}</textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
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

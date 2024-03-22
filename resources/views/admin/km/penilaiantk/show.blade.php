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
                    'title' => 'Penilaian TK',
                    'url' => route('penilaiantk.index'),
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
                            <h3 class="card-title"><i class="fas fa-list-ol"></i> {{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="callout callout-info">
                                <form action="{{ route('penilaiantk.create') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="term_id" class="col-sm-2 col-form-label">Term</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select select2" name="term_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="">-- Pilih Term --</option>
                                                @foreach ($data_term as $term_item)
                                                    <option value="{{ $term_item->id }}"
                                                        @if ($term_item->id == $term->id) selected @endif>
                                                        {{ $term_item->term }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Kelas</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select select2" name="kelas_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="" disabled>-- Pilih Kelas --</option>
                                                @foreach ($data_kelas as $kelas_item)
                                                    <option value="{{ $kelas_item->id }}"
                                                        @if ($kelas_item->id == $kelas->id) selected @endif>
                                                        {{ $kelas_item->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="d-md-block d-lg-flex">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <div class="table-responsive p-2 w-md-100">
                                        <table class="table table-bordered">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th style="width: 10%"">No</th>
                                                    <th style="width: 80%" class="d-md-table-cell">Name</th>
                                                    <th style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data_anggota_kelas as $anggota_kelas)
                                                    <tr
                                                        @if ($anggota_kelas->siswa->id == $siswa->id) style="background-color: #d3d3d38f" @endif>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $anggota_kelas->siswa->nama_lengkap }}</td>
                                                        <td class="text-center">
                                                            <form
                                                                action="{{ route('penilaiantk.show', $anggota_kelas->id) }}"
                                                                method="get">
                                                                @csrf
                                                                <input type="hidden" name="kelas_id"
                                                                    value="{{ $kelas->id }}">
                                                                <input type="hidden" name="term_id"
                                                                    value="{{ $term->id }}">
                                                                <input type="hidden" name="anggota_kelas_id"
                                                                    value="{{ $anggota_kelas->id }}">

                                                                <button class="btn btn-primary btn-sm" type="submit"
                                                                    @if ($anggota_kelas->siswa->id == $siswa->id) disabled @endif>
                                                                    <i class="fas fa-search"></i>
                                                                </button>

                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-8">
                                    <div class="table-responsive p-2">
                                        <form action="{{ route('penilaiantk.store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="anggota_kelas_id" value="{{ $anggotaKelas->id }}">
                                            <input type="hidden" name="term_id" value="{{ $term->id }}">
                                            <div class="d-flex justify-content-between align-items-center my-2">
                                                <h4 style="font-weight: bold; margin: auto 0 ">
                                                    {{ $siswa->nama_lengkap . ' - ' . $siswa->nisn }}
                                                </h4>
                                                <button class="btn btn-primary btn-sm rounded" type="submit"> Save</button>
                                            </div>
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
                                                                            ->where(
                                                                                'anggota_kelas_id',
                                                                                $anggotaKelas->id,
                                                                            )
                                                                            ->first();
                                                                    @endphp
                                                                    @if ($achivement)
                                                                        @foreach ($dataAchivements->where('tk_point_id', $point->id)->where('anggota_kelas_id', $anggotaKelas->id) as $achivement)
                                                                            <input type="hidden" name="tk_point_id[]"
                                                                                value="{{ $point->id }}">
                                                                            <tr>
                                                                                <td>{{ $point->name }}</td>
                                                                                <td>
                                                                                    <select class="form-control"
                                                                                        name="achivement[]">
                                                                                        <option value="">-- Pilih --
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
                                                                                <input type="hidden" name="tk_point_id[]"
                                                                                    value="{{ $point->id }}">
                                                                                <select class="form-control"
                                                                                    name="achivement[]">
                                                                                    <option value="">-- Pilih --
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
                                                                            ->where(
                                                                                'anggota_kelas_id',
                                                                                $anggotaKelas->id,
                                                                            )
                                                                            ->first();
                                                                    @endphp
                                                                    @if ($achivement)
                                                                        @foreach ($dataAchivements->where('tk_point_id', $point->id)->where('anggota_kelas_id', $anggotaKelas->id) as $achivement)
                                                                            <input type="hidden" name="tk_point_id[]"
                                                                                value="{{ $point->id }}">
                                                                            <tr>
                                                                                <td>{{ $point->name }}</td>
                                                                                <td>
                                                                                    <select class="form-control"
                                                                                        name="achivement[]">
                                                                                        <option value="">-- Pilih --
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
                                                                                <input type="hidden" name="tk_point_id[]"
                                                                                    value="{{ $point->id }}">
                                                                                <tr>
                                                                                    <td>{{ $point->name }}</td>
                                                                                    <td>
                                                                                        <select class="form-control"
                                                                                            name="achivement[]">
                                                                                            <option value="">-- Pilih
                                                                                                --
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
                                                                                    <input type="hidden"
                                                                                        name="tk_point_id[]"
                                                                                        value="{{ $point->id }}">
                                                                                    <select class="form-control"
                                                                                        name="achivement[]">
                                                                                        <option value="">-- Pilih --
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
                                                                            <input type="hidden" name="tk_point_id[]"
                                                                                value="{{ $point->id }}">
                                                                            <select class="form-control"
                                                                                name="achivement[]" id="achivement">
                                                                                <option value="">
                                                                                    -- Pilih --
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
                                                            <td><input type="text" class="form-control"
                                                                    name="event[]">
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
                                                        <td><input type="text" class="form-control"
                                                                name="no_school_days"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Days Attended</td>
                                                        <td><input type="text" class="form-control"
                                                                name="days_attended">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Days Absent</td>
                                                        <td><input type="text" class="form-control"
                                                                name="days_absent">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-primary btn-sm rounded"
                                                    type="submit">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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

@push('custom-scripts')
@endpush

@section('footer')
    @include('layouts.main.footer')
@endsection

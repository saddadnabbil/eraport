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
                                    {{-- <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Term</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{ $term->term }}" disabled>
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Kelas</label>
                                        <div class="col-sm-10">
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
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $anggota_kelas->siswa->nama_lengkap }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('penilaiantk.show', $anggota_kelas->id) }}"
                                                                class="btn btn-primary btn-sm"><i
                                                                    class="fas fa-search"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="table-responsive p-2" style="width: 65%">
                                        <h4 style="font-weight: bold">{{ $title }}</h4>
                                        <table class="table table-bordered">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th style="width: 90%"" class="text-center">Area of Learning &
                                                        Development</th>
                                                    <th style="width: 10%"">Achivement</th>
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

                                                                @php
                                                                    $subtopicId = $subtopic->id;
                                                                    if ($subtopicId == null) {
                                                                        $points = $dataTkPoints->where(
                                                                            'tk_topic_id',
                                                                            $topic->id,
                                                                        );
                                                                    } else {
                                                                        $points = $dataTkPoints->where(
                                                                            'tk_subtopic_id',
                                                                            $subtopicId,
                                                                        );
                                                                    }
                                                                @endphp

                                                                @foreach ($points as $point)
                                                            <tr>
                                                                <td>{{ $point->name }}</td>
                                                                <td><input type="text" class="form-control"
                                                                        name="achivement[]"></td>
                                                            </tr>
                                                        @endforeach
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                                @endforeach

                                            </tbody>
                                        </table>
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

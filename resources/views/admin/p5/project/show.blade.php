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
                    'title' => 'Manajemen P5BK',
                    'url' => route('p5.project.index'),
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
            {{-- data table --}}
            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title">{{ $title }}</h3>
                            <div class="card-tools ms-auto d-flex gap-2 justify-content-center">
                                <div data-bs-toggle="tooltip" data-bs-original-title="Nilai">
                                    <a href="#" class="btn btn-success btn-sm disabled" role="button">
                                        Nilai Project
                                    </a>
                                </div>
                                <div data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                    <a href="{{ route('p5.project.edit', $project->id) }}"
                                        class="btn btn-primary btn-sm ">Edit Project</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 mb-3">
                                <h6>Petunjuk Penilaian</h6>
                                <div class="table-responsive">
                                    <table id="example2" class="table table-striped table-bordered dataTable">
                                        <tbody>
                                            <tr>
                                                <td class="blue" style="text-align:center"><b>SB</b> - Sangat
                                                    Berkembang
                                                </td>
                                                <td class="blue" style="text-align:center"><b>BSH</b> - Berkembang
                                                    Sesuai
                                                    Harapan</td>
                                                <td class="blue" style="text-align:center"><b>MB</b> - Mulai
                                                    Berkembang
                                                </td>
                                                <td class="blue" style="text-align:center"><b>BB</b> - Belum
                                                    Berkembang
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <form action="{{ route('p5.project.nilai', $project->id) }}" method="POST">
                                @csrf
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="zero_config"
                                            class="table table-striped table-valign-middle table-bordered">
                                            <thead>
                                                <tr>
                                                <tr>
                                                    <th class="text-center orange" width="100">Nama</th>
                                                    <?php $no = 1; ?>
                                                    @foreach ($dataSubelement->where('has_active', true) as $subelement)
                                                        <th width="80" data-bs-toggle="tooltip" data-bs-html="true"
                                                            class="text-center orange"
                                                            title="
                                                            <b>Dimensi</b><br/>{{ $subelement->element->dimensi->name }}<hr/><b>Elemen</b><br/>{{ $subelement->element->name }}<b><hr/>Subelemen</b><br/>{{ $subelement->name }}
                                                            "
                                                            style="cursor:pointer">
                                                            {{ $no++ }}
                                                        </th>
                                                    @endforeach
                                                </tr>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataSiswa as $siswa)
                                                    <tr>
                                                        <td class="text-left">{{ $siswa->nama_lengkap }}</td>
                                                        @foreach ($dataSubelement->where('has_active', true) as $subelement)
                                                            <td class="text-center">
                                                                <input type="hidden"
                                                                    name="subelement_id[{{ $siswa->anggota_kelas->first()->id }}][]"
                                                                    value="{{ $subelement->id }}">
                                                                <input type="hidden"
                                                                    name="anggota_kelas_id[{{ $siswa->id }}]"
                                                                    value="{{ $siswa->anggota_kelas->first()->id }}">
                                                                @php $found = false; @endphp
                                                                @if (isset($gradeData[$siswa->anggota_kelas->first()->id]))
                                                                    @foreach ($gradeData[$siswa->anggota_kelas->first()->id] as $grade)
                                                                        @if ($grade['subelement_id'] == $subelement->id)
                                                                            @php $found = true; @endphp
                                                                            <select
                                                                                name="grade[{{ $siswa->anggota_kelas->first()->id }}][{{ $subelement->id }}]"
                                                                                class="form-control form-select">
                                                                                <option value="">-</option>
                                                                                <option value="BB"
                                                                                    {{ $grade['grade'] == 'BB' ? 'selected' : '' }}>
                                                                                    BB</option>
                                                                                <option value="MB"
                                                                                    {{ $grade['grade'] == 'MB' ? 'selected' : '' }}>
                                                                                    MB</option>
                                                                                <option value="BSH"
                                                                                    {{ $grade['grade'] == 'BSH' ? 'selected' : '' }}>
                                                                                    BSH</option>
                                                                                <option value="SB"
                                                                                    {{ $grade['grade'] == 'SB' ? 'selected' : '' }}>
                                                                                    SB</option>
                                                                            </select>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                @if (!$found)
                                                                    <select
                                                                        name="grade[{{ $siswa->anggota_kelas->first()->id }}][{{ $subelement->id }}]"
                                                                        class="form-control form-select">
                                                                        <option value="" selected>-</option>
                                                                        <option value="SB">SB</option>
                                                                        <option value="BSH">BSH</option>
                                                                        <option value="MB">MB</option>
                                                                        <option value="BB">BB</option>
                                                                    </select>
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <button id="printReportBtn" class="btn btn-danger px-5">
                                                                Rapor <br> P5BK
                                                            </button>
                                                        </td>
                                                        <td
                                                            colspan="{{ $dataSubelement->where('has_active', true)->count() }}">
                                                            <textarea name="catatan[{{ $siswa->anggota_kelas->first()->id }}]" class="form-control" cols="30" rows="3"
                                                                placeholder="Catatan Proses">{{ isset($catatanProses[$siswa->anggota_kelas->first()->id]) ? $catatanProses[$siswa->anggota_kelas->first()->id] : '' }}</textarea>

                                                        </td>
                                                    </tr>
                                                @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
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

@push('custom-scripts')
    <!-- JavaScript untuk membuka halaman Print Report -->
    <script>
        document.getElementById("printReportBtn").addEventListener("click", function() {
            var printReportUrl = "{{ route('p5.raport.show', $siswa->anggota_kelas->first()->id) }}" +
                "?paper_size=A4&orientation=potrait&semester_id={{ $tapel->semester_id }}";
            window.open(printReportUrl, "_blank");
        });
    </script>
@endpush

@section('footer')
    @include('layouts.main.footer')
@endsection

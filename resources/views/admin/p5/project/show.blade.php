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
                        <form action="{{ route('p5.nilai.project.update', $project->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="card-header d-flex align-items-center">
                                <h3 class="card-title">{{ $title }}</h3>
                                <div class="card-tools ms-auto">
                                    <a href="#" class="btn btn-success btn-sm disabled">
                                        Nilai Project
                                    </a>
                                    <a href="{{ route('p5.project.edit', $project->id) }}" class="btn btn-sm btn-primary">
                                        Edit Project
                                    </a>
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
                                                        <td class="text-left ">{{ $siswa->nama_lengkap }}</td>
                                                        @foreach ($dataSubelement->where('has_active', true) as $subelement)
                                                            <td class="text-center">
                                                                <input type="text" name="subelement_id[]"
                                                                    value="{{ $subelement->id }}" hidden>
                                                                <input type="text" name="anggota_kelas_id[]"
                                                                    value="{{ $siswa->anggota_kelas_id }}" hidden>
                                                                <select name="grade[]" id="grade"
                                                                    class="form-control form-select">
                                                                    <option value="SB">SB</option>
                                                                    <option value="BSH">BSH</option>
                                                                    <option value="MB">MB</option>
                                                                    <option value="BB">BB</option>
                                                                </select>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <a href="{{ route('p5.project.show', $project->id) }}"
                                                                class="btn btn-danger px-5">Rapor <br> P5BK</a>
                                                        </td>
                                                        <td
                                                            colspan="{{ $dataSubelement->where('has_active', true)->count() }}">
                                                            <textarea name="catatan[]" class="form-control" id="" cols="30" rows="3" placeholder="Catatan">
                                                                {{ $siswa->catatan_project }}
                                                            </textarea>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>

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

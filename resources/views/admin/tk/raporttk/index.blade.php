@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.admin')
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @php
            $user = Auth::user();
            $dashboard = route('admin.dashboard');
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
                            <h3 class="card-title"><i class="fas fa-print"></i> {{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="callout callout-info">
                                <form action="{{ route('tk.raport.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Term</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select" name="term_id" style="width: 100%;"
                                                required onchange="this.form.submit();">
                                                <option value="1" @if ($term->id == '1') selected @endif>1
                                                </option>
                                                <option value="2" @if ($term->id == '2') selected @endif>2
                                                </option>
                                                <option value="2" @if ($term->id == '3') selected @endif>3
                                                </option>
                                                <option value="2" @if ($term->id == '4') selected @endif>4
                                                </option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Kelas</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select select2" name="kelas_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="" disabled>-- Pilih Kelas --</option>
                                                @foreach ($data_kelas->sortBy('tingkatan_id') as $kls)
                                                    <option value="{{ $kls->id }}"
                                                        @if ($kls->id == $kelas->id) selected @endif>
                                                        {{ $kls->nama_kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="d-flex justify-content-end my-3 gap-2">
                                <form action="{{ route('tk.raport.export', $kelas->id) }}" target="_black" method="GET">
                                    @csrf
                                    <input type="hidden" name="data_type" value="1">
                                    <input type="hidden" name="paper_size" value="{{ $paper_size }}">
                                    <input type="hidden" name="orientation" value="{{ $orientation }}">
                                    <input type="hidden" name="term_id" value="{{ $term->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-print"></i> Print All Data
                                    </button>
                                </form>
                                <form action="{{ route('tk.raport.export', $kelas->id) }}" target="_black" method="get">
                                    @csrf
                                    <input type="hidden" name="data_type" value="2">
                                    <input type="hidden" name="paper_size" value="{{ $paper_size }}">
                                    <input type="hidden" name="orientation" value="{{ $orientation }}">
                                    <input type="hidden" name="term_id" value="{{ $term->id }}">

                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i> Print All Report Data
                                    </button>

                                </form>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="bg-info">
                                        <tr>
                                            <th class="text-center" style="width: 5%;">No</th>
                                            <th class="text-center" style="width: 5%;">NIS</th>
                                            <th class="text-center" style="width: 50%;">Nama Siswa</th>
                                            <th class="text-center" style="width: 5%;">L/P</th>
                                            <th class="text-center" style="width: 15%;">Kelengkapan Raport</th>
                                            <th class="text-center" style="width: 15%;">Raport</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @if ($data_anggota_kelas->count() == 0)
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @else
                                            @foreach ($data_anggota_kelas as $anggota_kelas)
                                                <?php $no++; ?>
                                                <tr>
                                                    <input type="hidden" name="anggota_kelas_id[]"
                                                        value="{{ $anggota_kelas->id }}">
                                                    <td class="text-center">{{ $no }}</td>
                                                    <td class="text-center">{{ $anggota_kelas->siswa->nis }}</td>
                                                    <td>{{ $anggota_kelas->siswa->nama_lengkap }}</td>
                                                    <td class="text-center">{{ $anggota_kelas->siswa->jenis_kelamin }}</td>
                                                    <td class="text-center">
                                                        <form action="{{ route('tk.raport.show', $anggota_kelas->id) }}"
                                                            target="_black" method="GET">
                                                            @csrf
                                                            <input type="hidden" name="data_type" value="1">
                                                            <input type="hidden" name="paper_size"
                                                                value="{{ $paper_size }}">
                                                            <input type="hidden" name="orientation"
                                                                value="{{ $orientation }}">
                                                            <input type="hidden" name="term_id"
                                                                value="{{ $term->id }}">
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-print"></i> Cetak Data
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <td class="text-center">
                                                        <form action="{{ route('tk.raport.show', $anggota_kelas->id) }}"
                                                            target="_black" method="GET">
                                                            @csrf
                                                            <input type="hidden" name="data_type" value="2">
                                                            <input type="hidden" name="paper_size"
                                                                value="{{ $paper_size }}">
                                                            <input type="hidden" name="orientation"
                                                                value="{{ $orientation }}">
                                                            <input type="hidden" name="term_id"
                                                                value="{{ $term->id }}">
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-print"></i> Cetak Raport
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
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
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
@endsection

@section('footer')
    @include('layouts.main.footer')
@endsection

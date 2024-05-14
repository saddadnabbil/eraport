@extends('layouts.main.header')

@section('sidebar')
    @include('layouts.sidebar.index')
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        @include('layouts.partials.breadcrumbs._breadcrumbs-item', [
            'titleBreadCrumb' => $title,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('admin.dashboard'),
                    'active' => true,
                ],
                [
                    'title' => 'Data Pembelajaran',
                    'url' => route('tk.pembelajaran.index'),
                    'active' => false,
                ],
                [
                    'title' => $title,
                    'url' => '',
                    'active' => false,
                ],
            ],
        ])
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ./row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-cog"></i> {{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group row callout callout-info mx-1">
                                <label for="kelas_id" class="col-sm-2 col-form-label">Kelas</label>
                                <div class="col-sm-10">
                                    <form action="{{ route('tk.pembelajaran.settings') }}" method="POST">
                                        @csrf
                                        <select class="form-control form-select select2" name="kelas_id"
                                            style="width: 100%;" required onchange="this.form.submit();">
                                            <option value="" disabled> -- Pilih Kelas --</option>
                                            <option value="" selected>{{ $kelas->nama_kelas }}
                                                @foreach ($data_kelas as $d_kelas)
                                                    @if ($d_kelas->id != $kelas->id)
                                            <option value="{{ $d_kelas->id }}">
                                                {{ $d_kelas->nama_kelas }}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                            <form action="{{ route('tk.pembelajaran.store') }}" method="POST">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Tingkatan</th>
                                                <th>Kelas</th>
                                                <th>Topic</th>
                                                <th>Guru</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_pembelajaran_kelas as $pembelajaran)
                                                <tr>
                                                    <td>{{ $pembelajaran->tingkatan->nama_tingkatan }}
                                                    </td>
                                                    <td>{{ $pembelajaran->kelas->nama_kelas }}
                                                    </td>
                                                    <td>{{ $pembelajaran->topic->name }}
                                                        <input type="hidden" name="pembelajaran_id[]"
                                                            value="{{ $pembelajaran->id }}">
                                                    </td>
                                                    <td>
                                                        <select class="form-control form-select select2"
                                                            name="update_guru_id[]" style="width: 100%;">
                                                            <option value="">-- Pilih Guru -- </option>
                                                            @foreach ($data_guru as $guru)
                                                                <option value="{{ $guru->id }}"
                                                                    @if ($pembelajaran->guru && $pembelajaran->guru->id == $guru->id) selected @endif>
                                                                    {{ $guru->karyawan->nama_lengkap }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            @foreach ($data_topic as $topic)
                                                <tr>
                                                    <td>{{ $kelas->tingkatan->nama_tingkatan }}
                                                        <input type="hidden" name="tingkatan_id[]"
                                                            value="{{ $kelas->tingkatan->id }}">
                                                    </td>
                                                    <td>{{ $kelas->nama_kelas }}
                                                        <input type="hidden" name="kelas_id[]"
                                                            value="{{ $kelas->id }}">
                                                    </td>
                                                    <td>
                                                        {{ $topic->name }}
                                                        <input type="hidden" name="tk_topic_id[]"
                                                            value="{{ $topic->id }}">
                                                    </td>
                                                    <td>
                                                        <select class="form-control form-select select2" name="guru_id[]"
                                                            style="width: 100%;">
                                                            <option value="">-- Pilih Guru -- </option>
                                                            @foreach ($data_guru as $guru)
                                                                <option value="{{ $guru->id }}">
                                                                    {{ $guru->karyawan->nama_lengkap }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        </div>

                        <div class="card-footer clearfix">
                            <button type="submit" class="btn btn-success float-right">Simpan</button>
                        </div>
                        </form>
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

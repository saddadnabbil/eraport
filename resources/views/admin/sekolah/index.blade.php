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
                    'url' => route('admin.sekolah.index'),
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-friends"></i> {{ $title }}</h3>
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Create" class="d-inline-block">
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
                                        <h5 class="modal-title">Tambah {{ $title }}</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.sekolah.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="nama_sekolah" class="col-sm-2 col-form-label">School
                                                    Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nama_sekolah"
                                                        name="nama_sekolah" placeholder="School Name"
                                                        value="{{ old('nama_sekolah') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="npsn" class="col-sm-2 col-form-label">NPSN</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="npsn" name="npsn"
                                                        placeholder="NPSN" value="{{ old('npsn') }}">
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <label for="nss" class="col-sm-2 col-form-label">NSS
                                                    <small><i>(opsional)</i></small></label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="nss" name="nss"
                                                        placeholder="NSS" value="{{ old('nss') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="alamat" class="col-sm-2 col-form-label">Address</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Address">{{ old('alamat') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kode_pos" class="col-sm-2 col-form-label">Postal Code</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="kode_pos"
                                                        name="kode_pos" placeholder="Postal Code"
                                                        value="{{ old('kode_pos') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nomor_telpon" class="col-sm-2 col-form-label">Telephone</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="nomor_telpon"
                                                        name="nomor_telpon" placeholder="Telephone"
                                                        value="{{ old('nomor_telpon') }}"
                                                        data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']"
                                                        data-mask>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="website" class="col-sm-2 col-form-label">Website
                                                    <small><i>(opsional)</i></small></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="website" name="website"
                                                        placeholder="Website" value="{{ old('website') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" placeholder="Email" value="{{ old('email') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kepala_sekolah"
                                                    class="col-sm-2 col-form-label">Principal</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="kepala_sekolah"
                                                        name="kepala_sekolah" placeholder="Principal"
                                                        value="{{ old('kepala_sekolah') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nip_kepala_sekolah" class="col-sm-2 col-form-label">NIP
                                                    Principal</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="nip_kepala_sekolah"
                                                        name="nip_kepala_sekolah" placeholder="NIP Principal"
                                                        value="{{ old('nip_kepala_sekolah') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="ttd_kepala_sekolah" class="col-sm-2 col-form-label">Principal
                                                    Signature</label>
                                                <div class="col-sm-5">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control"
                                                            name="ttd_kepala_sekolah" id="ttd_kepala_sekolah"
                                                            onchange="readURLTtd(this);" accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                                        id="ttd_kepala_sekolah_preview" style="width: 190px;">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="logo" class="col-sm-2 col-form-label">School Logo</label>
                                                <div class="col-sm-5">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control"
                                                            name="logo" id="logo" onchange="readURLLogo(this);"
                                                            accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <img src="{{ asset('assets/dist/img/preview.png') }}" alt=""
                                                        id="pas_photo_preview" style="width: 190px;">
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
                                <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Sekolah</th>
                                            <th>NPSN</th>
                                            <th>Kepala Sekolah</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($sekolahs->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center">No data available in table</td>
                                            </tr>
                                        @else
                                            @foreach ($sekolahs as $key => $sekolah)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $sekolah->nama_sekolah }}</td>
                                                    <td>{{ $sekolah->npsn }}</td>
                                                    <td>{{ $sekolah->kepala_sekolah }}</td>
                                                    <td>
                                                        @include('components.actions.delete-button', [
                                                            'route' => route(
                                                                'admin.sekolah.destroy',
                                                                $sekolah->id),
                                                            'id' => $sekolah->id,
                                                            'isPermanent' => true,
                                                            'withEdit' => false,
                                                            'withShow' => true,
                                                            'showRoute' => route(
                                                                'admin.sekolah.show',
                                                                $sekolah->id),
                                                        ])
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
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
    </div>
@endsection

@push('custom-scripts')
    <!-- pas_photo preview-->
    <script>
        function readURLTtd(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#ttd_kepala_sekolah_preview').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLLogo(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#pas_photo_preview').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush

@section('footer')
    @include('layouts.main.footer')
@endsection

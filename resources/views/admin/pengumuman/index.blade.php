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
                    'url' => route('admin.dashboard'),
                    'active' => true,
                ],
                [
                    'title' => $title,
                    'url' => route('pengumuman.index'),
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
                            <h3 class="card-title">{{ $title }}</h3>
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Tambah" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-tambah">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal tambah  -->
                        <div class="modal fade" id="modal-tambah">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Posting Pengumuman Baru</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                        </button>
                                    </div>
                                    <form action="{{ route('pengumuman.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Judul Pengumuman</label>
                                                <input type="text" class="form-control" name="judul"
                                                    value="{{ old('judul') }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Isi Pengumuman</label>
                                                <textarea class="textarea" name="isi"
                                                    style="width: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 5px;" required>{{ old('isi') }}</textarea>
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

                        <div class="col-md-12 col-lg-12">
                            <div class="card-body">
                                <h4 class="card-title">Recent Announcement</h4>
                                <div class="mt-4 activity">
                                    @foreach ($data_pengumuman->sortByDesc('created_at') as $pengumuman)
                                        <div class="d-flex align-items-start border-left-line">
                                            <div>
                                                <a href="javascript:void(0)" class="btn btn-cyan btn-circle mb-2 btn-item">
                                                    <i data-feather="bell"></i>
                                                </a>
                                            </div>
                                            <div class="ms-3 mt-2">
                                                <h5 class="text-body font-weight-medium mb-2 text-wrap">
                                                    {{ $pengumuman->judul }}
                                                </h5>
                                                <div>
                                                    <p class="font-14 mb-2 text-muted text-wrap text-break note-editable">
                                                        {!! $pengumuman->isi !!}
                                                    </p>
                                                </div>
                                                <span
                                                    class="font-weight-light font-14 mb-1 d-block text-muted">{{ $pengumuman->user->karyawan->nama_lengkap }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($pengumuman->created_at)->diffForHumans() }}</span>
                                                @if (Auth::user()->id == $pengumuman->user_id)
                                                    @include('components.actions.delete-button', [
                                                        'route' => route('pengumuman.destroy', $pengumuman->id),
                                                        'id' => $pengumuman->id,
                                                        'isPermanent' => true,
                                                        'withEdit' => true,
                                                        'withShow' => false,
                                                    ])
                                                @endif
                                            </div>
                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $pengumuman->id }}">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('pengumuman.update', $pengumuman->id) }}"
                                                            method="POST">
                                                            {{ method_field('PATCH') }}
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Judul Pengumuman</label>
                                                                    <input type="text" class="form-control"
                                                                        name="judul" value="{{ $pengumuman->judul }}"
                                                                        readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Isi Pengumuman</label>
                                                                    <textarea class="textarea" name="isi"
                                                                        style="width: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 5px;" required>{!! $pengumuman->isi !!}</textarea>
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
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Container fluid  -->
                <!-- ============================================================== -->
            </div>
        @endsection

        @push('custom-scripts')
            <!-- Summernote -->
            <script src="{{ asset('assets/libs/summernote/summernote-bs4.min.js') }}"></script>
            <script>
                $(function() {
                    // Summernote
                    $('.textarea').summernote()
                })
            </script>
        @endpush

        @section('footer')
            @include('layouts.main.footer')
        @endsection

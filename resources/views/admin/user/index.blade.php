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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-friends"></i> {{ $title }}</h3>
                            <div class="card-tools">
                                <div data-bs-toggle="tooltip" title="Tambah" class="d-inline-block">
                                    <button type="button" class="btn btn-tool btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-tambah">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div data-bs-toggle="tooltip" title="Export" class="d-inline-block">
                                    <a href="{{ route('user.export') }}" class="btn btn-tool btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                <div data-bs-toggle="tooltip" title="Trash" class="d-inline-block" class="d-inline-block">
                                    <a href="{{ route('user.trash') }}" class="btn btn-tool btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Modal tambah  -->
                        <div class="modal fade" id="modal-tambah">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah {{ $title }} Admin</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                        </button>
                                    </div>
                                    <form action="{{ route('user.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama
                                                    Lengkap</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nama_lengkap"
                                                        name="nama_lengkap" placeholder="Nama Lengkap"
                                                        value="{{ old('nama_lengkap') }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis
                                                    Kelamin</label>
                                                <div class="col-sm-9 pt-1">
                                                    <label class="radio-inline me-3"><input type="radio"
                                                            name="jenis_kelamin" value="Male"
                                                            @if (old('jenis_kelamin') == 'Male') checked @endif required>
                                                        Male</label>
                                                    <label class="radio-inline me-3"><input type="radio"
                                                            name="jenis_kelamin" value="Female"
                                                            @if (old('jenis_kelamin') == 'Female') checked @endif required>
                                                        Female</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tanggal_lahir" class="col-sm-3 col-form-label">Tanggal
                                                    Lahir</label>
                                                <div class="col-sm-9">
                                                    <input type="date" class="form-control" id="tanggal_lahir"
                                                        name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        placeholder="Email" value="{{ old('email') }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nomor_hp" class="col-sm-3 col-form-label">Nomor HP</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="nomor_hp"
                                                        name="nomor_hp" placeholder="Nomor HP" value="{{ old('nomor_hp') }}"
                                                        required>
                                                </div>
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

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>Username</th>
                                            <th>Level</th>
                                            <th>Status Akun</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($data_user as $user)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>
                                                    @if ($user->role == 1)
                                                        {{ $user->admin->nama_lengkap }}
                                                    @elseif($user->role == 2)
                                                        {{ $user->guru->nama_lengkap }}
                                                    @elseif ($user->role == 3)
                                                        @if ($user->siswa)
                                                            {{ $user->siswa->nama_lengkap }}
                                                        @else
                                                            -
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $user->username }}</td>
                                                <td>
                                                    @if ($user->role == 1)
                                                        Administrator
                                                    @elseif($user->role == 2)
                                                        Guru
                                                    @elseif($user->role == 3)
                                                        Siswa
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($user->status == true)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Non Aktif</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @include('components.actions.delete-button', [
                                                        'route' => route('user.destroy', $user->id),
                                                        'id' => $user->id,
                                                        'isPermanent' => false,
                                                        'withEdit' => true,
                                                        'withShow' => false,
                                                    ])
                                                </td>
                                            </tr>

                                            <!-- Modal edit  -->
                                            <div class="modal fade" id="modal-edit{{ $user->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit {{ $title }}</h5>

                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-hidden="true"></button>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('user.update', $user->id) }}"
                                                            method="POST">
                                                            {{ method_field('PATCH') }}
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <label for="nama_lengkap"
                                                                        class="col-sm-3 col-form-label">Nama
                                                                        Lengkap</label>
                                                                    <div class="col-sm-9">
                                                                        @if ($user->role == 1)
                                                                            <input type="text" class="form-control"
                                                                                name="nama_lengkap"
                                                                                value="{{ $user->admin->nama_lengkap }}"
                                                                                readonly>
                                                                        @elseif($user->role == 2)
                                                                            <input type="text" class="form-control"
                                                                                name="nama_lengkap"
                                                                                value="{{ $user->guru->nama_lengkap }}"
                                                                                readonly>
                                                                        @elseif($user->role == 3)
                                                                            @if ($user->siswa)
                                                                                <input type="text" class="form-control"
                                                                                    name="nama_lengkap"
                                                                                    value="{{ $user->siswa->nama_lengkap }}"
                                                                                    readonly>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="username"
                                                                        class="col-sm-3 col-form-label">Username</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            name="username" value="{{ $user->username }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="password"
                                                                        class="col-sm-3 col-form-label">Password</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="password" class="form-control"
                                                                            name="password" placeholder="Password Baru"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="status"
                                                                        class="col-sm-3 col-form-label">Status Akun</label>
                                                                    <div class="col-sm-9 pt-1">
                                                                        <label class="radio-inline me-3"><input
                                                                                type="radio" name="status"
                                                                                value="1"
                                                                                @if ($user->status == 1) checked @endif
                                                                                required> Aktif</label>
                                                                        <label class="radio-inline me-3"><input
                                                                                type="radio" name="status"
                                                                                value="0"
                                                                                @if ($user->status == 0) checked @endif
                                                                                required> Non Aktif</label>
                                                                    </div>
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
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    </div>
@endsection

@push('custom-scripts')
    @include('components.sweet-alert-script')
@endpush

@section('footer')
    @include('layouts.main.footer')
@endsection

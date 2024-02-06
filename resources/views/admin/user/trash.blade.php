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
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Level</th>
                                            <th>Status Akun</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        @foreach ($userTrashed as $user)
                                            <?php $no++; ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>
                                                    @if ($user->role == 1)
                                                        {{ $user->username }}
                                                    @elseif($user->role == 2)
                                                        {{ $user->username }}
                                                    @elseif ($user->role == 3)
                                                        {{ $user->username }}
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
                                                <td class=" text-center">
                                                    <div class="d-flex gap-2">
                                                        @include('components.actions.restore-button', [
                                                            'route' => route('user.restore', [
                                                                'id' => $user->id,
                                                            ]),
                                                            'id' => $user->id,
                                                            'method' => 'PATCH',
                                                        ])
                                                        @include('components.actions.delete-button', [
                                                            'route' => route('user.permanent-delete', [
                                                                'id' => $user->id,
                                                            ]),
                                                            'id' => $user->id,
                                                            'isPermanent' => true,
                                                            'withEdit' => false,
                                                            'withShow' => false,
                                                        ])
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
@endpush

@section('footer')
    @include('layouts.main.footer')
@endsection

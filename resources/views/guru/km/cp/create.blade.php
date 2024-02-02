@extends('layouts.main.header')

@section('sidebar')
    @include('layouts.sidebar.guru')
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
                    'url' => route('dashboard'),
                    'active' => true,
                ],
                [
                    'title' => 'Capaian Pelajaran',
                    'url' => route('guru.cp.index'),
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
                            <h3 class="card-title"><i class="fas fa-clipboard-list"></i> {{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="callout callout-info">
                                <form action="{{ route('guru.cp.create') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Kelas</label>
                                        <div class="col-sm-10">
                                            <select class="form-control form-select select2" name="pembelajaran_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="" disabled>-- Pilih Kelas --</option>
                                                @foreach ($data_pembelajaran as $pembelajaran)
                                                    <option value="{{ $pembelajaran->id }}"
                                                        @if ($pembelajaran->id == $pembelajaran_id) selected @endif>
                                                        {{ $pembelajaran->mapel->nama_mapel }}
                                                        ({{ $pembelajaran->kelas->nama_kelas }} -
                                                        {{ $pembelajaran->kelas->tingkatan->nama_tingkatan }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <form id="dynamic_form" action="{{ route('guru.cp.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="mapel_id" value="{{ $mapel_id }}">
                                <input type="hidden" name="tingkatan_id" value="{{ $tingkatan_id }}">
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <input type="hidden" name="pembelajaran_id" value="{{ $pembelajaran_id }}">

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 100px;">Kode CP</th>
                                                <th>Capaian Pembelajaran</th>
                                                <th>Ringkasan Capaian Pembelajaran</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($existingData && count($existingData) > 0)
                                                @foreach ($existingData as $data)
                                                    <tr>
                                                        <td {!! $data->canDelete
                                                            ? ''
                                                            : 'data-bs-target="popover" data-placement="right" title data-content="<b>Tidak Bisa Diedit.</b> <br> Sedang digunakan dalam salah satu penilaian"' !!}>
                                                            <input type="text" class="form-control" name="kode_cp[]"
                                                                value="{{ $data->kode_cp }}" required
                                                                oninvalid="this.setCustomValidity('data tidak boleh kosong')"
                                                                oninput="setCustomValidity('')"
                                                                {{ $data->canDelete ? '' : 'disabled' }}>
                                                        </td>

                                                        <td {!! $data->canDelete
                                                            ? ''
                                                            : 'data-bs-target="popover" data-placement="right" title data-content="<b>Tidak Bisa Diedit.</b> <br> Sedang digunakan dalam salah satu penilaian"' !!}>
                                                            <textarea class="form-control" name="capaian_pembelajaran[]" rows="2" required
                                                                oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')"
                                                                {{ $data->canDelete ? '' : 'disabled' }}>{{ $data->capaian_pembelajaran }}</textarea>
                                                        </td>

                                                        <td {!! $data->canDelete
                                                            ? ''
                                                            : 'data-bs-target="popover" data-placement="right" title data-content="<b>Tidak Bisa Diedit.</b> <br> Sedang digunakan dalam salah satu penilaian"' !!}>
                                                            <textarea class="form-control" name="ringkasan_cp[]" rows="2" required
                                                                oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')"
                                                                {{ $data->canDelete ? '' : 'disabled' }}>{{ $data->ringkasan_cp }}</textarea>
                                                        </td>

                                                        <td class="text-center">
                                                            <button type="button"
                                                                class="btn btn-danger shadow btn-xs sharp"
                                                                id="deleteButton{{ $data->id }}"
                                                                onclick="{{ $data->canDelete ? 'deleteData(' . $data->id . ')' : '' }}"
                                                                {{ $data->canDelete ? '' : 'data-bs-target="popover" data-placement="right" title="Tidak Bisa Dihapus" data-content="<b>Sedang digunakan dalam salah satu penilaian.</b>" disabled' }}>
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                            <button type="button" name="add" id="add"
                                                                class="btn btn-primary shadow btn-xs sharp"><i
                                                                    class="fa fa-plus"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control" name="kode_cp[]" required
                                                            oninvalid="this.setCustomValidity('data tidak boleh kosong')"
                                                            oninput="setCustomValidity('')">
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="capaian_pembelajaran[]" rows="2" required
                                                            oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')"></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="ringkasan_cp[]" rows="2" required
                                                            oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')"></textarea>
                                                    </td>
                                                    <td><button type="button" name="add" id="add"
                                                            class="btn btn-primary shadow btn-xs sharp"><i
                                                                class="fa fa-plus"></i></button></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                        </div>

                        <div class="card-footer clearfix">
                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                            <a href="{{ route('guru.cp.index') }}" class="btn btn-default float-right me-2">Batal</a>
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

@push('custom-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var count = {{ isset($existingData) ? count($existingData) : 1 }};

            // Jika tidak ada existingData, panggil dynamic_field
            @if (!isset($existingData) || count($existingData) == 0)
                dynamic_field(count);
            @endif

            function dynamic_field(number) {
                html = '<tr>';
                html += '<td>' +
                    '<input type="text" class="form-control" name="kode_cp[]" oninvalid="this.setCustomValidity(\'data tidak boleh kosong\')" oninput="setCustomValidity(\'\')">' +
                    '</td>';
                html += '<td>' +
                    '<textarea class="form-control" name="capaian_pembelajaran[]" rows="2" oninvalid="this.setCustomValidity(\'data tidak boleh kosong\')" oninput="setCustomValidity(\'\')"></textarea>' +
                    '</td>';
                html += '<td>' +
                    '<textarea class="form-control" name="ringkasan_cp[]" rows="2" oninvalid="this.setCustomValidity(\'data tidak boleh kosong\')" oninput="setCustomValidity(\'\')"></textarea>' +
                    '</td>';

                if (number > 1) {
                    html +=
                        '<td class="text-center" ><button type="button" name="remove" class="btn btn-danger shadow btn-xs sharp remove"><i class="fa fa-trash"></i></button></td></tr>';
                    $('tbody').append(html);
                } else {
                    html +=
                        '<td class="text-center" ><button type="button" name="add" id="add" class="btn btn-primary shadow btn-xs sharp"><i class="fa fa-plus"></i></button></td></tr>';
                    $('tbody').html(html);
                }
            }

            $(document).on('click', '#add', function() {
                count++;
                dynamic_field(count);
            });

            $(document).on('click', '.remove', function() {
                count--;
                $(this).closest("tr").remove();
            });
        });
    </script>

    <script>
        $(function() {
            $('[data-bs-target="popover"]').popover({
                trigger: 'hover',
                placement: function(popoverEl, targetEl) {
                    return $(targetEl).data('placement');
                },
                html: true,
            });
        });

        function deleteData(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('guru.cp.destroy', ':id') }}".replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            $('#row_' + id).remove();

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Capaian Pembelajaran deleted successfully.',
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            // Show error SweetAlert alert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Error deleting record. Please try again.',
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush

@section('footer')
    @include('layouts.main.footer')
@endsection

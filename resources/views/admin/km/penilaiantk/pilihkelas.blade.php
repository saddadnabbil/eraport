@extends('layouts.main.header')
@section('sidebar')
    @include('layouts.sidebar.index')
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
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="callout callout-info">
                                <form action="{{ route('tk.penilaian.create') }}" method="GET">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="term_id" class="col-sm-2 col-form-label">Term</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select select2" name="term_id"
                                                style="width: 100%;" required>
                                                <option value="">-- Pilih Term --</option>
                                                @foreach ($data_term as $term_item)
                                                    <option value="{{ $term_item->id }}"
                                                        @if ($term_item->id == $term) selected @endif>
                                                        {{ $term_item->term }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label for="kelas_id" class="col-sm-2 col-form-label">Kelas</label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-select select2" name="kelas_id"
                                                style="width: 100%;" required onchange="this.form.submit();">
                                                <option value="">-- Pilih Kelas --</option>
                                                @foreach ($data_kelas as $kelas)
                                                    <option value="{{ $kelas->id }}">
                                                        {{ $kelas->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
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
    <!-- ajax get class id and show class name-->
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="term_id"]').on('change', function() {
                var term_id = $(this).val();
                if (term_id) {
                    $.ajax({
                        url: '/getKelas/penilaian-tk/' + term_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="kelas_id"').empty();

                            $('select[name="kelas_id"]').append(
                                '<option value="">-- Select Class Name --</option>'
                            );

                            $.each(data, function(i, data) {
                                $('select[name="kelas_id"]').append(
                                    '<option value="' +
                                    data.kelas_id + '">' + data.nama_kelas +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="kelas_id"').empty();
                }
            });
        });
    </script> --}}
@endpush

@section('footer')
    @include('layouts.main.footer')
@endsection

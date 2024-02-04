@extends('layouts.main.header')

@section('sidebar')
  @include('layouts.sidebar.guru')
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
            ]
        ]
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
              <h3 class="card-title"> {{$title}}</h3>
            </div>

            <div class="card-body">
              <div class="callout callout-info">
                <form action="{{ route('nilaiekstra.create') }}" method="GET">
                  @csrf
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ekstrakulikuler</label>
                    <div class="col-sm-10">
                      <select class="form-control form-select select2" name="ekstrakulikuler_id" style="width: 100%;" required>
                        <option value="">-- Pilih Ekstrakulikuler --</option>
                        @foreach($data_ekstrakulikuler as $ekstrakulikuler)
                        <option value="{{$ekstrakulikuler->id}}">{{$ekstrakulikuler->nama_ekstrakulikuler}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kelas</label>
                    <div class="col-sm-10">
                      <select class="form-control form-select select2" name="kelas_id" style="width: 100%;" required onchange="this.form.submit();">
                        <!--  -->
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
  <!-- ajax -->
  <script type="text/javascript">
    $(document).ready(function() {
      $('select[name="ekstrakulikuler_id"]').on('change', function() {
        var ekstrakulikuler_id = $(this).val();
        if (ekstrakulikuler_id) {
          $.ajax({
            url: '/guru/getKelas/ekstra/' + ekstrakulikuler_id,
            type: "GET",
            dataType: "json",
            success: function(data) {
              $('select[name="kelas_id"').empty();

              $('select[name="kelas_id"]').append(
                '<option value="">-- Pilih Kelas --</option>'
              );

              $.each(data, function(i, data) {
                $('select[name="kelas_id"]').append(
                  '<option value="' +
                  data.id + '">' + data.nama_kelas + '</option>');
              });
            }
          });
        } else {
          $('select[name="kelas_id"').empty();
        }
      });
    });
  </script>
@endpush

@section('footer')
  @include('layouts.main.footer')
@endsection


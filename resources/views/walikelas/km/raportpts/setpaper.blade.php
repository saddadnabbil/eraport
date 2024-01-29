@include('layouts.main.header')
@include('layouts.sidebar.walikelas')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{$title}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item "><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- ./row -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-print"></i> {{$title}}</h3>
            </div>

            <div class="card-body">

              <div class="callout callout-info">
                <form action="{{ route('raportptskm.store') }}" method="POST">
                  @csrf
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Term</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="term_id" style="width: 100%;" required>
                          <option value="">-- Pilih Term --</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                      </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Semester</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="semester_id" style="width: 100%;" required onchange="this.form.submit()">
                          <option value="">-- Pilih Semester --</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                      </select>
                    </div>
                  </div>
                </form>
              </div>
          </div>
          <!-- /.card -->
        </div>

      </div>
      <!-- /.row -->
    </div>
    <!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('layouts.main.footer')
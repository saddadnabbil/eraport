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
        'breadcrumbs' => [
            [
                'title' => 'Dashboard',
                'url' => route('dashboard'),
                'active' => true,
            ],
            [
                'title' => $title,
                'url' => route('sekolah.index'),
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
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-school"></i> {{$title}}</h3>
            </div>
            <div class="card-body">
              <form name="contact-form" action="{{ route('sekolah.update', $sekolah->id )}}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="form-group row">
                  <label for="nama_sekolah" class="col-sm-2 col-form-label">Nama Sekolah</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" placeholder="Nama Sekolah" value="{{$sekolah->nama_sekolah}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="npsn" class="col-sm-2 col-form-label">NPSN</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="npsn" name="npsn" placeholder="NPSN" value="{{$sekolah->npsn}}">
                  </div>

                </div>
                <div class="form-group row">
                  <label for="nss" class="col-sm-2 col-form-label">NSS <small><i>(opsional)</i></small></label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="nss" name="nss" placeholder="NSS" value="{{$sekolah->nss}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat">{{$sekolah->alamat}}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="kode_pos" class="col-sm-2 col-form-label">Kode Pos</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="kode_pos" name="kode_pos" placeholder="Kode Pos" value="{{$sekolah->kode_pos}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="nomor_telpon" class="col-sm-2 col-form-label">Telepon</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="nomor_telpon" name="nomor_telpon" placeholder="Telepon" value="{{ intval(str_replace('-', '', $sekolah->nomor_telpon)) }}" data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" data-mask>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="website" class="col-sm-2 col-form-label">Website <small><i>(opsional)</i></small></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="website" name="website" placeholder="Website" value="{{$sekolah->website}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$sekolah->email}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="kepala_sekolah" class="col-sm-2 col-form-label">Kepala Sekolah</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="kepala_sekolah" name="kepala_sekolah" placeholder="Kepala Sekolah" value="{{$sekolah->kepala_sekolah}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="nip_kepala_sekolah" class="col-sm-2 col-form-label">NIP Kepala Sekolah <small><i>(opsional)</i></small></label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="nip_kepala_sekolah" name="nip_kepala_sekolah" placeholder="NIP Kepala Sekolah" value="{{$sekolah->nip_kepala_sekolah}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="logo" class="col-sm-2 col-form-label">Logo Sekolah</label>
                  <div class="col-sm-5">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input form-control" name="logo" id="customFile" onchange="readURL(this);" accept="image/*">
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    @if ($sekolah->logo == null)
                      {{-- <img src="{{ asset('assets/dist/img/3x4.png') }}" alt="" id="pas_photo_preview"> --}}
                    @else
                      <img class="mb-2" src="{{ asset('assets/images/logo/'.$sekolah->logo) }}" id="pas_photo_preview" alt="{{$sekolah->logo}}">
                    @endif
                  </div>
                </div>
                <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                    <div class="checkbox">
                      <input type="checkbox" required> Perbarui data profil sekolah
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </div>
              </form>
            </div>
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


      <!-- pas_photo preview-->
      <script>
          function readURL(input) {
              if (input.files && input.files[0]) {
                  var reader = new FileReader();
      
                  reader.onload = function (e) {
                      $('#pas_photo_preview')
                          .attr('src', e.target.result);
                  };
      
                  reader.readAsDataURL(input.files[0]);
              }
          }
      </script>
  @endpush
  
  @section('footer')
    @include('layouts.main.footer')
  @endsection
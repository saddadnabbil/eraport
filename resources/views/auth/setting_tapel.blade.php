  @include('layouts.auth.header')
  <!-- ============================================================== -->
  <!-- Login box.scss -->
  <!-- ============================================================== -->
  <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative" style="background:url({{ asset('assets/images/big/auth-bg.jpg') }}) no-repeat center center;">
    <div class="auth-box row">
        <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url({{ asset('assets/images/img-login-upacara.png') }});">
        </div>
          <div class="col-lg-5 col-md-7 bg-white">
              <div class="p-3">
                  <div class="text-center">
                      <img src="{{ asset('assets/images/logo-gis-circle.png') }}" alt="wrapkit">
                  </div>
                  <h2 class="mt-3 text-center font-18 mb-3">Register Academic Year</h2>
                    <form method="post" action="{{ route('setting.tapel') }}">
                      @csrf
                      <div class="row">
                          <div class="col-lg-12">
                              <div class="form-group mb-3">
                                  <input class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" placeholder="Tahun Pelajaran" value="{{old('tahun_pelajaran')}}">
                              </div>
                          </div>
                          <div class="mb-3">
                            <select class="form-control form-select" name="semester" style="width: 100%;">
                              <option value="">-- Select Semester -- </option>
                              <option value="1">Semester Ganjil </option>
                              <option value="2">Semester Genap </option>
                            </select>
                          </div>
                          <div class="mb-3">
                            <select class="form-control form-select" name="term" style="width: 100%;">
                              <option value="">-- Pilih Term -- </option>
                              <option value="1">Term 1  </option>
                              <option value="2">Term 2  </option>
                            </select>
                          </div>
                          <div class="col-lg-12 text-center">
                              <button type="submit" class="btn w-100 btn-dark">Register</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
  </div>
  @include('layouts.auth.footer')
  @include('layouts.auth.header')
  <!-- ============================================================== -->
  <!-- Login box.scss -->
  <!-- ============================================================== -->
  <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
      style="background:url({{ asset('assets/images/big/auth-bg.jpg') }}) no-repeat center center;">
      <div class="auth-box row">
          <div class="col-lg-7 col-md-5 modal-bg-img"
              style="background-image: url({{ asset('assets/images/img-login-upacara.png') }});">
          </div>
          <div class="col-lg-5 col-md-7 bg-white">
              <div class="p-3">
                  <div class="text-center">
                      <img src="{{ asset('assets/images/logo-gis-circle.png') }}" alt="wrapkit">
                  </div>
                  <h2 class="mt-3 text-center font-18 mb-3">Change Password</h2>

                  <form method="post" action="{{ route('gantipassword') }}">
                      @csrf
                      <div class="row">
                          <div class="col-lg-12">
                              <div class="form-group mb-3">
                                  <input class="form-control" id="password_lama" name="password_lama" type="password"
                                      placeholder="password lama">
                              </div>
                          </div>
                          <div class="col-lg-12">
                              <div class="form-group mb-3">
                                  <input class="form-control" id="pwd" name="password_baru" type="password"
                                      placeholder="password baru">
                              </div>
                          </div>
                          <div class="col-lg-12">
                              <div class="form-group mb-3">
                                  <input class="form-control" id="pwd" name="konfirmasi_password" type="password"
                                      placeholder="konfirmasi password">
                              </div>
                          </div>
                          <div class="col-lg-12 text-center">
                              <button type="submit" class="btn w-100 btn-dark">Change Password</button>
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

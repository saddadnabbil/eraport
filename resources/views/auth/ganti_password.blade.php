  @include('layouts.auth.header')
  <!-- ============================================================== -->
  <!-- Login box.scss -->
  <!-- ============================================================== -->
  <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative">
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
                                  <input class="form-control @error('password_lama') is-invalid @enderror"
                                      id="password_lama" name="password_lama" type="password" placeholder="old password"
                                      required>
                                  @error('password_lama')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-lg-12">
                              <div class="form-group mb-3">
                                  <input class="form-control @error('password_baru') is-invalid @enderror"
                                      id="password_baru" name="password_baru" type="password" placeholder="new password"
                                      required>
                                  @error('password_baru')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-lg-12">
                              <div class="form-group mb-3">
                                  <input class="form-control @error('konfirmasi_password') is-invalid @enderror"
                                      id="konfirmasi_password" name="konfirmasi_password" type="password"
                                      placeholder="confirm password" required>
                                  @error('konfirmasi_password')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-lg-6 text-center">
                              <a href="{{ route('login') }}" class="btn w-100 btn-primary">Cancel</a>
                          </div>
                          <div class="col-lg-6 text-center">
                              <button type="submit" class="btn w-100 btn-danger">Submit</button>
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

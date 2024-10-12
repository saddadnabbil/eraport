  @include('layouts.auth.header')
  <!-- ============================================================== -->
  <!-- Login box.scss -->
  <!-- ============================================================== -->
  {{-- <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative">
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
  </div> --}}
  <main class="main" id="top">
      <div class="container-fluid">
          <div class="row min-vh-100 bg-100">
              <div class="col-6 d-none d-lg-block position-relative">
                  <div class="bg-holder"
                      style="background-image:url('{{ asset('https://alsyukrouniversal.sch.id/images/alsyukrouniversal-profile-dir-2023.jpg') }}');
                        background-position: center;
                        background-size: cover;
                        height: 100%;
                        width: 100%;
                        background-repeat: no-repeat;
                        
                    ">
                  </div>
                  <!--/.bg-holder-->
              </div>
              <div class="col-sm-10 col-md-6 px-sm-0 align-self-center mx-auto py-5">
                  <div class="row justify-content-center g-0">
                      <div class="col-lg-9 col-xl-8 col-xxl-6 text-center">
                          <div class="d-flex justify-content-center">
                              <img src="https://alsyukrouniversal.sch.id/images/logo-alsyukro-ok.png" alt="image"
                                  style="width: 350px; height: auto; object-fit: contain;">
                          </div>
                          <div class="card mt-4">
                              <div class="card-body p-4">
                                  <div class="row flex-between-center">
                                      <div class="col-auto">
                                          <h3 class="mb-4">Change Password</h3>
                                      </div>
                                  </div>


                                  <form method="post" action="{{ route('gantipassword') }}">
                                      @csrf
                                      <div class="row">
                                          <div class="col-lg-12">
                                              <div class="form-group mb-3">
                                                  <input
                                                      class="form-control @error('password_lama') is-invalid @enderror"
                                                      id="password_lama" name="password_lama" type="password"
                                                      placeholder="old password" required>
                                                  @error('password_lama')
                                                      <div class="invalid-feedback">
                                                          {{ $message }}
                                                      </div>
                                                  @enderror
                                              </div>
                                          </div>
                                          <div class="col-lg-12">
                                              <div class="form-group mb-3">
                                                  <input
                                                      class="form-control @error('password_baru') is-invalid @enderror"
                                                      id="password_baru" name="password_baru" type="password"
                                                      placeholder="new password" required>
                                                  @error('password_baru')
                                                      <div class="invalid-feedback">
                                                          {{ $message }}
                                                      </div>
                                                  @enderror
                                              </div>
                                          </div>
                                          <div class="col-lg-12">
                                              <div class="form-group mb-3">
                                                  <input
                                                      class="form-control @error('konfirmasi_password') is-invalid @enderror"
                                                      id="konfirmasi_password" name="konfirmasi_password"
                                                      type="password" placeholder="confirm password" required>
                                                  @error('konfirmasi_password')
                                                      <div class="invalid-feedback">
                                                          {{ $message }}
                                                      </div>
                                                  @enderror
                                              </div>
                                          </div>
                                          <div class="col-lg-6 text-center">
                                              <a href="{{ route('login') }}" class="btn w-100 btn-secondary">Cancel</a>
                                          </div>
                                          <div class="col-lg-6 text-center">
                                              <button type="submit" class="btn w-100 btn-success">Submit</button>
                                          </div>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </main>
  <!-- ============================================================== -->
  <!-- Login box.scss -->
  <!-- ============================================================== -->
  </div>
  @include('layouts.auth.footer')

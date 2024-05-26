@include('layouts.auth.header')
<!-- ============================================================== -->
<!-- Login box.scss -->
<!-- ============================================================== -->
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
    style="border-radius: 15px 0px 0px 15px;">
    <div class="auth-box row">
        <div class="col-lg-7 col-md-5 modal-bg-img"
            style="background-image: url({{ asset('assets/images/img-login-upacara.png') }});">
        </div>
        <div class="col-lg-5 col-md-7 bg-white form-box" style="">
            <div class="p-3">
                <div class="text-center">
                    <img src="{{ asset('assets/images/logo-gis-circle.png') }}" alt="wrapkit">
                </div>
                <h2 class="mt-3 text-center font-18 mb-3">Sign In</h2>


                @error('username')
                    <div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
                        <p>There is no account matching that username/password</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror

                <form method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <input class="form-control" id="uname" name="username" type="text"
                                    placeholder="username">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <input class="form-control" id="pwd" name="password" type="password"
                                    placeholder="password">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-check mb-3">
                                <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck2"
                                    style="border: 2px solid #4F5467;">
                                <label class="form-check-label" for="exampleCheck2">Remember me</label>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn w-100 btn-dark rounded">Sign In</button>
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

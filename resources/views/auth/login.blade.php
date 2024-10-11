@include('layouts.auth.header')
<!-- ============================================================== -->
<!-- Login box.scss -->
<!-- ============================================================== -->

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
                                        <h3 class="mb-4">Login</h3>
                                    </div>
                                </div>

                                @error('username')
                                    <div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
                                        <p>There is no account matching that username/password</p>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @enderror

                                <form method="post" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3 text-start">
                                        <label class="form-label" for="uname">
                                            Username
                                        </label>
                                        <input class="form-control" id="uname" name="username" type="text"
                                            placeholder="username" />
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between"><label class="form-label"
                                                for="pwd">Password</label></div><input class="form-control"
                                            id="pwd" name="password" type="password" placeholder="password" />
                                    </div>
                                    <div class="row flex-between-center">
                                        <div class="col-auto">
                                            <div class="form-check mb-0"><input class="form-check-input" name="remember"
                                                    style="border: 2px solid green" type="checkbox"
                                                    id="split-checkbox" />
                                                <label class="form-check-label mb-0" for="split-checkbox">Remember
                                                    me</label>
                                            </div>
                                        </div>
                                        {{-- <div class="col-auto"><a class="fs--1"
                                                href="../../../pages/authentication/split/forgot-password.html">Forgot
                                                Password?</a></div> --}}
                                    </div>
                                    <div class="mb-3"><button class="btn d-block w-100 mt-3 text-light" type="submit"
                                            name="submit" style="background-color: #006e3b">Log in</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->

@include('layouts.auth.footer')

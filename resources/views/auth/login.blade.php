@include('layouts.styles.headercss')
<body id="kt_body" class="bg-body">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url({{ asset('media/illustrations/sketchy-1/14.png') }}">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <a href="#" class="mb-12">
                    <img alt="Logo" src="{{ asset('media/logos/logo-1.svg') }}" class="h-40px" />
                </a>
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <div class="alert alert-danger d-none" id="errorAlert" role="alert">
                        <div id="emailMsg"> </div>
                    </div>
                    <form class="form w-100" novalidate="novalidate" id="loginFormRsw" method="POST">
                        @csrf
                        <div class="text-center mb-10">
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">
                                <b>{{ session('success') }}</b>
                            </div>
                            {{ Session::forget('success') }}
                        @endif
                        <div class="fv-row mb-10">
                            <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" />
                        </div>
                        <div class="fv-row mb-10">
                            <div class="d-flex flex-stack mb-2">
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                <a href="#" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
                            </div>
                            <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
                            <b style="color: red" id="passwordMsg"></b>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="submitLoginDetails" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">Continue</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.styles.footerjs')

</body>
<script>
    var loginUrl = "{{ route('login.post') }}";
</script>

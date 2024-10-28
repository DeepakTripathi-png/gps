@extends('admin.layouts.master')
@section('content')
{{-- <div class="login-main"
    style="background-image: url('{{ asset('assets/admin/images/login.jpg') }}')">
    <div class="container custom-container">
        <div class="row justify-content-center">
            <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-8 col-sm-11">
                <div class="login-area">
                    <div class="login-wrapper">
                        <div class="login-wrapper__top">
                            <h3 class="title text-white">@lang('Welcome to') <strong>{{ __($general->site_name) }}</strong></h3>
                            <p class="text-white">{{ __($pageTitle) }} @lang('to') {{ __($general->site_name) }}
                                @lang('Dashboard')</p>
                        </div>
                        <div class="login-wrapper__body">
                            <form action="{{ route('admin.login') }}" method="POST"
                                class="cmn-form mt-30 verify-gcaptcha login-form">
                                @csrf
                                <div class="form-group">
                                    <label>@lang('Username')</label>
                                    <input type="text" class="form-control" name="username" value="{{ old('username') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Password')</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <x-captcha />
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" name="remember" type="checkbox" id="remember">
                                        <label class="form-check-label" for="remember">@lang('Remember Me')</label>
                                    </div>
                                    <a href="{{ route('admin.password.reset') }}"
                                        class="forget-text">@lang('Forgot Password?')</a>
                                </div>
                                <button type="submit" class="btn cmn-btn w-100">@lang('LOGIN')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="section-authentication-cover">
    <div class="">
      <div class="row g-0">
        <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left  justify-content-center d-none d-xl-flex bg-primary">
          <img src="{{ asset("/assets/images/cover-login.png") }}" class="img-fluid auth-img-cover-login" width=""alt="">
          <div class="card rounded-0 mb-0 border-0 bg-transparent">
            <div class="card-body">
            </div>
          </div>
        </div>

        <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
          <div class="card rounded-0 m-3 mb-0 border-0">
            <div class="card-body p-sm-5">
              <img src="{{ asset("/assets/images/logo-icon.svg") }}" class="mb-4 d-block  mx-auto " width="180" alt="" >
              <div class="form-body mt-4">
                <form action="{{ route('admin.login') }}" method="POST">
                  @csrf
                <div class="col-12">
                    <label for="inputEmailAddress" class="form-label">Email</label>
                    <input type="text" class="form-control  border-3" id="inputEmailAddress" name="username" placeholder="jhon@example.com" required>
                  </div>
                  <div class="col-12">
                    <label for="inputChoosePassword" class="form-label">Password</label>
                    <div class="input-group" id="show_hide_password">
                      <input type="password" class="form-control border-end-0 border-3" id="inputChoosePassword" name="password" placeholder="Enter Password" required>
                      <a href="#" class="input-group-text bg-transparent border-3 toggle-password">
                        <i class="bi bi-eye-slash-fill"></i>
                      </a>
                    </div>
                  </div>
                  <div class="col-md-8 my-2">
                    <div class="form-check form-switch  border-3">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                      <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                    </div>
                  </div>
                  {{-- <div class="col-md-6 text-end">	<a href="{{ route('admin.password.reset') }}">Forgot Password ?</a> --}}
                  </div>
                  <div class="col-12">
                    <div class="d-grid">
                      <button type="submit" class="btn  border-3 btn-primary">Login</button>
                    </div>
                  </div>
                </form>
              </div>

          </div>
          </div>
        </div>

      </div>
      <!--end row-->
    </div>
  </div>
@endsection
@push('script')
<script>
  const passwordInput = document.getElementById('inputChoosePassword');
  const togglePasswordBtn = document.querySelector('.toggle-password');

  togglePasswordBtn.addEventListener('click', function (e) {
    e.preventDefault();

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      togglePasswordBtn.innerHTML = '<i class="bi bi-eye-fill"></i>';
    } else {
      passwordInput.type = 'password';
      togglePasswordBtn.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
    }
  });
</script>
@endpush
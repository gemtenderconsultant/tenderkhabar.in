@extends('layouts.app')
@section('title', 'Stay Updated with Login Tender Khabar | Latest News & Updates')
@section('meta_description', 'Discover the latest updates with Login Tender Khabar. Stay informed and never miss out on important news. Click to explore our comprehensive updates today!')  
@section('stylesheet')
@endsection
@section('content')
<main id="main">
  <!-- ======= Breadcrumbs ======= -->
  <div class="breadcrumbs">
    <div class="page-header d-flex align-items-center" style="background-image: url('assets/img/page-header.jpg');">
      <div class="container position-relative">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-6 text-center">
            <h2>Login</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Breadcrumbs -->
  <section id="login" class="about">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card border-primary">
            <div class="card-body">
              <div class="row d-flex align-items-center justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-6">
                  <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg" class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-4 col-lg-5 col-xl-5 offset-xl-1">
                  <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email input -->
                    <label class="form-label" for="email">{{ __('Email Address') }}</label>
                    <div class="form-outline mb-4">
                      <input type="email" id="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                      @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                      <label class="form-label" for="password">{{ __('Password') }}</label>
                      <input type="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" />
                      @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="d-flex justify-content-around align-items-center mb-4">
                      <!-- Checkbox -->
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                        <label class="form-check-label" for="remember"> {{ __('Remember Me') }} </label>
                      </div>
                      @if (Route::has('password.request'))
                          <a href="{{ route('password.request') }}">Forgot password?</a>
                      @endif
                      
                    </div>
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-dark btn-lg btn-block"> {{ __('Login') }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
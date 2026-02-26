@extends('layouts.app') @section('content') <main id="main">
@section('title', 'Register on Tender Khabar | Easy & Secure Registration')
@section('meta_description', 'Join Tender Khabar today! Our simple and secure register process ensures you stay updated with the latest news and offers. Don’t miss out—register now for exclusive access!')  
  <!-- ======= Breadcrumbs ======= -->
  <div class="breadcrumbs">
    <div class="page-header d-flex align-items-center" style="background-image: url('assets/img/page-header.jpg');">
      <div class="container position-relative">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-6 text-center">
            <h2>Register</h2>
            <!-- <p>Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p> -->
          </div>
        </div>
      </div>
    </div>
    <nav>
      <div class="container">
        <ol>
          <li>
            <a href="{{ asset('/') }}">Home</a>
          </li>
          <li>Register</li>
        </ol>
      </div>
    </nav>
  </div>
  <!-- End Breadcrumbs -->
  <section id="register" class="about">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card border-primary">
            <div class="card-header" style="background-color:#1e3a8a">{{ __('Register') }}</div>
            <div class="card-body">
              <form method="POST" action="{{ route('register') }}"> 
                  @csrf 
                  <div class="row mb-3">
                  <input type="hidden" name="status" value="Free">
                  <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                  <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus> @error('name') <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span> @enderror
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                  <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"> @error('email') <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span> @enderror
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="company_name" class="col-md-4 col-form-label text-md-end">{{ __('company Name') }}</label>
                  <div class="col-md-6">
                    <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="off"> @error('company_name') <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span> @enderror
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="mobile" class="col-md-4 col-form-label text-md-end">{{ __('Mobile') }}</label>
                  <div class="col-md-6">
                    <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="off" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" minlength="10"> @error('mobile') <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>@enderror
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                  <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"> @error('password') <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span> @enderror
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                  <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-4"></div>
                  <p class="col-md-6"><strong>Note: add multiple keywords with comma separated</strong></p>
                  <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Enter your keywords') }}</label>
                  <div class="col-md-6">
                    <textarea id="keyword" type="text" class="form-control" required name="keyword"></textarea>
                  </div>
                </div>

                <div class="row mb-0">
                  <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-dark sb-userproduct">
                      {{ __('Register') }}
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End About Us Section -->
</main> @endsection

@section('scripts')
<script>
$('body').on('click', '.sb-userproduct', function() {
    var TCode = document.getElementById('keyword').value;
    if(TCode == ""){
        alert('Please enter keywords!');
        return false;
    }else{
      if (/[^a-zA-Z0-9 ,\-\/]/.test(TCode)) {
        alert('Input is not alphanumeric! Remove special character in keywords.');
        return false;
      }
    }
    

    return true;
});
</script>
@endsection
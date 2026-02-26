@extends('backend.layouts.app')
@section('content')
<div class="container py-5 mt-5">
  <div class="row d-flex justify-content-center align-items-center h-100 pt-5">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
      <div class="card bg-light text-dark" style="border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
        <div class="card-body p-5">
          <div class="mb-4 text-center">
            <h2 class="fw-bold mb-2 text-uppercase">Change Password</h2>
            <p class="text-dark-50 mb-0">Please enter your Old password to continue</p>
              @if (session('status'))
                  <div class="alert alert-success">{{ session('status') }}</div>
              @endif
          </div>
          <form method="POST" action="{{ route('password.update2')}}">
            @csrf
            <div class="form-outline form-white mb-4">
              <div class="input-group mb-3">
                <span class="input-group-text bg-primary text-white"><i class="fas fa-lock"></i></span>
                <input type="password" id="current_password" name="current_password" class="form-control form-control-lg @error('current_password') is-invalid @enderror"  placeholder="Enter current password"  autocomplete="current-password">
                @error('current_password')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text bg-primary text-white"><i class="fas fa-lock-open"></i></span>
                <input type="password" id="new_password" name="new_password" class="form-control form-control-lg @error('new_password') is-invalid @enderror" placeholder="Enter new password" autocomplete="current-password">
                @error('new_password')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
              <div class="input-group">
                <span class="input-group-text bg-primary text-white"><i class="fas fa-key"></i></span>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control form-control-lg @error('new_password_confirmation') is-invalid @enderror" placeholder="Confirm new password" autocomplete="current-password">
              </div>
              @error('new_password_confirmation')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <button class="btn btn-primary btn-lg btn-block w-100" type="submit">Change Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@extends('layouts.app')
@section('content')
<div class="login-mesh-gradient"></div>
<div class="login-page">
    <div class="login-card">
        <a href="#" class="login-logo">
            <i data-lucide="shield-check" style="color:var(--gold)" size="24"></i>
            Tender<span>Khabar</span>
        </a>

        <div class="login-header">
            <h1>Welcome To Tenderkhabar</h1>
            <!-- <p>Access your procurement intelligence terminal</p> -->
        </div>
            <form method="POST" action="{{ route('login') }}">
                    @csrf
            <div class="login-form-group">
                <label>Email Address</label>
                <div class="login-input-wrapper">
                    <input type="email" id="email" class="login-input @error('email') is-invalid @enderror" placeholder="name@company.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                    @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                </div>
            </div>

            <div class="login-form-group">
                <label>Password</label>
                <div class="login-input-wrapper">
                    <input type="password" id="password" class="login-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"  placeholder="••••••••" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                </div>
                <a href="#" class="login-forgot-link">Forgot Password?</a>
            </div>

            <button type="submit" class="login-btn-login">Sign In</button>
        </form>

        <p class="login-footer-text">
            Don't have an account? <a href="#">Sign Up</a>
        </p>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        lucide.createIcons();
    </script>
@endsection
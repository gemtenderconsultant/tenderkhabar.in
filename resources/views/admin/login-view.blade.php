<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login | TenderKhabar</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="{{ asset('assets/css/style1.css') }}" rel="stylesheet">
</head>
<body>

    <div class="login-mesh-gradient"></div>
    <div class="login-page">
        <div class="login-card">
            <a href="#" class="login-logo">
                <i data-lucide="shield-check" style="color:var(--gold)" size="24"></i>
                Tender<span>Khabar</span>
            </a>

            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Access your procurement intelligence terminal</p>
            </div>
            @if(session('error'))
            <div style="color:red;margin-bottom:10px;">
                {{ session('error') }}
            </div>
            @endif
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="login-form-group">
                    <label>Email Address</label>
                    <div class="login-input-wrapper">
                        <input type="email"  id="email" name="email" class="login-input" value="{{ old('email') }}" placeholder="name@company.com" required>
                    </div>
                </div>

                <div class="login-form-group">
                    <label>Password</label>
                    <div class="login-input-wrapper">
                        <input type="password" id="password" name="password" class="login-input"  @error('password') is-invalid @enderror" placeholder="••••••••" required>
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
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
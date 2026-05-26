@extends('layouts.app')

@section('content')

    <div class="signup-mesh-gradient"></div>
<div class="signup-body">
    <div class="signup-card">
        <div class="signup-header">
            <h1>Your Inquriy</h1>
            <!-- <p>Join the terminal for real-time tender intelligence</p> -->
        </div>

        <form class="signup-form">
            <!-- Name -->
            <div class="signup-form-group">
                <label class="signup-label">Name</label>
                <input type="text" class="signup-input" placeholder="Enter your full name">
            </div>

            <!-- Email -->
            <div class="signup-form-group">
                <label class="signup-label">Email Address</label>
                <input type="email" class="signup-input" placeholder="name@company.com">
            </div>

            <!-- Company -->
            <div class="signup-form-group">
                <label class="signup-label">Company Name</label>
                <input type="text" class="signup-input" placeholder="Organization name">
            </div>

            <!-- Mobile -->
            <div class="signup-form-group">
                <label class="signup-label">Mobile</label>
                <input type="tel" class="signup-input" placeholder="+91 00000-00000">
            </div>

            <!-- Keywords Section -->
            <div class="signup-keyword-wrapper">
                <div class="signup-form-group signup-align-top">
                    <label class="signup-label">Enter your inquriy</label>
                    <textarea class="signup-textarea" placeholder="e.g. Road Construction, Civil Works, Bridges..."></textarea>
                </div>
            </div>

            <div class="signup-action-area">
                <button type="submit" class="signup-btn-register">Register</button>
                <p class="signup-footer-text">Already have an account? <a href="#">Login</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
        lucide.createIcons();
    </script>
@endsection
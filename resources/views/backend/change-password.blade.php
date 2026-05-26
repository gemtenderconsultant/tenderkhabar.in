@extends('backend.layouts.app')
@section('content')
    <main class="changepass-wrapper">
        <div class="changepass-card">
            <h1 class="changepass-title">Change Password</h1>
             @if (session('status'))
                  <div class="alert alert-success">{{ session('status') }}</div>
              @endif  
            <p class="changepass-subtitle">Please enter your Old password to continue</p>

            <form method="POST" action="{{ route('password.update2')}}">
            @csrf
                <div class="changepass-form-group">
                    <div class="changepass-icon-box">
                        <i data-lucide="lock" size="18"></i>
                    </div>
                    <input type="password" class="changepass-input" name="current_password" placeholder="Enter current password">
                     @error('current_password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="changepass-form-group">
                    <div class="changepass-icon-box">
                        <i data-lucide="unlock" size="18"></i>
                    </div>
                    <input type="password" class="changepass-input" name="new_password" placeholder="Enter new password">
                    @error('new_password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="changepass-form-group">
                    <div class="changepass-icon-box">
                        <i data-lucide="key" size="18"></i>
                    </div>
                    <input type="password" class="changepass-input" name="new_password_confirmation" placeholder="Confirm new password">
                    @error('new_password_confirmation')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="changepass-btn-submit">Change Password</button>
            </form>

            <div class="changepass-footer">
                <a href="#" class="changepass-btn-back">Back to Profile</a>
            </div>
        </div>
    </main>
@endsection

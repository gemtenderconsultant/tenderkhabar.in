@extends('admin.layouts.app')
@section('stylesheet')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="content-area">
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <h3 class="mb-0 fw-bold">Change Password</h3>
        <button class="btn btn-primary px-4 py-2">
            <a style="color: #ffff; text-decoration: none;" href="{{ asset('admin/dashboard')}}"> Back</a>
        </button>
    </div>
    
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="mb-0">{{ $message }}</p>
        </div>
    @endif
    <!-- Inquiries Table Card -->
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('changePassword') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <strong>Current Password:</strong>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="********">
                        @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-xs-4 col-sm-4 col-lg-4">
                  <div class="form-group">
                    <strong>Password:</strong>
                    <input type="password" name="password" value="" class="form-control @error('password') is-invalid @enderror" placeholder="********">
                    @error('password')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-4">
                  <div class="form-group">
                    <strong>Confirm Password:</strong>
                    <input type="password" name="password_confirmation" value="" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="********">
                    @error('new_password')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-end">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@extends('admin.layouts.app')
@section('stylesheet')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 mt-2"></div>
    </div>
    @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p class="mb-0">{{ $message }}</p>
      </div>
    @endif

    <div class="row">
      <div class="col-lg-12 mt-2">   
        <div class="card card-default">
            <div class="card-header">
              <div class="float-left">
                <h2>Change Password</h2>
              </div>
              <div class="float-right">
                <a class="btn btn-warning" href="{{ asset('admin/dashboard')}}"> Back</a>
              </div>
            </div>   
            <div class="card-body">  
              <form action="{{ route('changepwd') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-xs-4 col-sm-4 col-lg-4">
                  <div class="form-group">
                    <strong>Email:</strong>
                    <select name="user" class="form-control" id="client">
                      @if(old('user'))
                        @php 
                          $user = \App\Models\User::where('id',old('user'))->first();
                        @endphp
                          <option value="{{ old('user') }}" selected="selected">
                              {{ old('name') ?? $user->email }}
                          </option>
                      @endif
                    </select>
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
    </div>
  </div>
</section> 
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#client').select2({
    placeholder: 'Search Email',
    ajax: {
      url: '{{ route("ajax-user-select") }}',
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          q: params.term // search term
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.id,
              text: item.name
            };
          })
        };
      },
    }
  });
});
</script>
@endsection
@extends('admin.layouts.app')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 mt-2">
        <div class="card card-default">
          <div class="card-header">
            <div class="float-left">
              <h2>Add New Admin</h2>
            </div>
            <div class="float-right">
              <a class="btn btn-primary" href="{{ route('adminlist') }}"> Back</a>
            </div>
          </div>
          <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
              <strong>Error!</strong> <br>
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            <form action="{{ route('admins.store') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Name">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <strong>Email:</strong>
                    <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <strong>Password:</strong>
                    <input type="text" name="password" value="{{ old('password') }}" class="form-control" placeholder="password">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
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
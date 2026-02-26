@extends('admin.layouts.app')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-2">
            <div class="float-left">
                <h2> Show Admin</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-primary" href="{{ route('adminlist') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $admin->name }}
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{ $admin->email }}
            </div>
        </div>
        
    </div>
    </div>
  </section>     
@endsection
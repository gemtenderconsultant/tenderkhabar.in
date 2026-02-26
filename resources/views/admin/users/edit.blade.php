@extends('admin.layouts.app')
   
@section('content')
<section class="content">
  <div class="container-fluid">
   
   
   <div class="row">
    <div class="col-lg-12 mt-2">   
        <div class="card card-default">

         <div class="card-header">
            <div class="float-left">
                <h2>Edit User</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
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
  
    <form action="{{ route('users.update',$user->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Company Name:</strong>
                    <input type="text" name="company_name" value="{{ $user->company_name }}" class="form-control" placeholder="Company Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="text" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Alternate Email: (add multiple emails with comma separated)</strong>
                        <input type="text" name="alt_email" value="{{ $user->alt_email }}" class="form-control" placeholder="Alternate Email">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Mobile:</strong>
                        <input type="text" name="mobile" value="{{ $user->mobile }}" class="form-control" placeholder="Mobile">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Status:</strong>
                        <select class="form-control" name="status">
                                <option value="Free" {{ $user->status=="Free" ? 'selected' : '' }}>Free</option>
                                 <option value="Paid" {{ $user->status=="Paid" ? 'selected' : '' }}>Paid</option>
                         </select>   
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="is_tender" value="1" {{ $user->is_tender == 1 ? 'checked' : '' }}>
                          <label for="customCheckbox1" class="custom-control-label">Tender Active</label>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input class="custom-control-input" type="checkbox" id="customCheckbox2" name="is_result" value="1" {{ $user->is_result == 1 ? 'checked' : '' }}>
                          <label for="customCheckbox2" class="custom-control-label">Result Active</label>
                        </div>
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
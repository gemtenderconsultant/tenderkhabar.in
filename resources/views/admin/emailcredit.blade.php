@extends('admin.layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Emails Credit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Emails Credit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3>
                  <div class="float-left">
                    <h2>List Emails Credit</h2>
                  </div>
                  <div class="float-right"></div>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="table-responsive">
                      <table id="user_service_inquiry_table" class="table table-bordered table-hover dataTable">
                        <thead>
                          <tr role="row">
                            <th>#</th>
                            <th>Name</th>
                            <th>Total Credit</th>   
                            <th>Date</th>   
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $k => $val)
                            <tr>
                                <td>{{ $k + 1 }}</td>
                                <td>{{ $val->portal_name }}</td>   
                                <td>{{ $val->totalemails }}</td> 
                                <td>{{ $val->created_at }}</td>   
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
        </div>
    </div>    
</section>    
@endsection
@extends('admin.layouts.app')

@section('stylesheet')
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-2">
           
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="mb-0">{{ $message }}</p>
        </div>
    @endif
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3>
               <div class="float-left">
                  <h2>List UserServiceInquiry</h2>
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
                        <th>Email</th>
                        <th>Company</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Flag</th>
                      </tr>
                    </thead>
                    <tbody>
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

@section('scripts')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    
    $('#user_service_inquiry_table').DataTable({
        "processing": true,
        "serverSide": true,
         stateSave: true,
         autoWidth: false,
        "order": [[ 0, "desc" ]],
         ajax: "{{route('userserviceinquirylist')}}",
         columns: [
        {data: 'sid', name: 'sid'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'company_name', name: 'company_name'},
        {data: 'user_primary_phone', name: 'user_primary_phone'},
        {data: 'insert_date_time', name: 'insert_date_time'},
        {data: 'flag', name: 'flag'},
        ],
    });

  });
</script>
@endsection
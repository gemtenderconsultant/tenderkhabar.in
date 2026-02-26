@extends('admin.layouts.app')
@section('stylesheet')
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <!-- <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}"> -->
@endsection
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Users</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('user-list')}}">Users</a></li>
          <li class="breadcrumb-item active">List</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">User List</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12">
                  <table id="user_table" class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                    <thead>
                      <tr role="row">
                        <th>Code</th>
                        <th>User</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section> 
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // DataTable
    $('#user_table').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{route('user-list')}}",
       columns: [
          { data: 'user_code' },
          { data: 'username' },
          { data: 'company_name' },
          { data: 'email' },
          { data: 'name' },
          { data: 'phone' },
          { data: 'action' },

       ]
    });
    
  });

  $('body').on('click','.refresh-json',function(event){
      var id = $(this).attr('data');
      alert(id);
      var csrf_token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
           type: "POST",
           url: "{{ route('refresh-user-json-list') }}",
           data: {'id':id,'_token':csrf_token},
           success: function(response) {
              if(response.status == "success"){
                 $('#user_table').DataTable().ajax.reload();
              }

              if(response.status == "error"){
                 $('#user_table').DataTable().ajax.reload();
              } 
           },
       });
  });
  
</script>
@endsection
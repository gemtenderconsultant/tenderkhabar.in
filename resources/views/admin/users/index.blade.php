@extends('admin.layouts.app')

@section('stylesheet')
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <!-- <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}"> -->
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
                        <h2>List Users</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
                    </div>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              
                  <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                          <table id="user_table" class="table table-bordered table-hover dataTable">
                            <thead>
                              <tr role="row">
                                <th>#</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                <!-- <th>Alt Email</th> -->
                                <th>Mobile</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Done Activation</th>
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
</div>
</section>     
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    
    $('#user_table').DataTable({
        "processing": true,
        "serverSide": true,
         stateSave: true,
         autoWidth: false,
        "order": [[ 0, "desc" ]],
         ajax: "{{route('user-list')}}",
         columns: [
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},
        {data: 'company_name', name: 'company_name'},
        {data: 'email', name: 'email'},
        {data: 'mobile', name: 'mobile'},
        {data: 'status', name: 'status'},
        {data: 'aname', name: 'admins.name'},
        {data: 'checkuser', name: 'id'},
        {data: 'action', name: 'action'}],
    });
});

$('body').on('click','.btn-danger',function(event){
    if (confirm('Are you sure want to delete ?')) {
        return true;
    }
    return false;
});    

$('body').on('click','.refresh-json',function(event){
  var id = $(this).attr('data');
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

$('body').on('click','.change-password',function(event){
  var id = $(this).attr('data-user_id');
  var csrf_token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: "{{ route('update-password') }}",
       data: {'id':id,'_token':csrf_token},
       success: function(response) {
        if(response.status == "success"){
          alert(response.msg);
        }

        if(response.status == "error"){
          alert(response.msg);
        }
       },
   });
});
</script>
@endsection
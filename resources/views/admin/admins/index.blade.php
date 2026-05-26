@extends('admin.layouts.app')
@section('content')

<div class="content-area">
    <!-- Header with Create Button -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <h3 class="mb-0 fw-bold">List Admins</h3>
        <button class="btn btn-success px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addAdminModal">
            <i class="bi bi-plus-lg me-1"></i> Create New Admin
        </button>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="mb-0">{{ $message }}</p>
        </div>
    @endif
    <!-- Admins Table Card -->
    <div class="card">
        <div class="card-body p-4">
            <!-- Responsive Table -->
            <div class="table-responsive">
                <table id="user_table" class="table table-bordered table-hover dataTable">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 30%;">Name</th>
                            <th style="width: 40%;">Email</th>
                            <th style="width: 25%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============================== ADMIN MODALS ============================== -->

<!-- 1. ADD NEW ADMIN MODAL -->
<div class="modal fade" id="addAdminModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add New Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admins.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Name:</label>
                        <input type="text" class="form-control form-control-lg"  name="name" value="{{ old('name') }}" placeholder="Name">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email:</label>
                        <input type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" placeholder="Email">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password:</label>
                        <input type="password" class="form-control form-control-lg" name="password" value="{{ old('password') }}" placeholder="password">
                    </div>
                    <div class="text-center mt-5">
                        <button type="submit"  class="btn btn-primary px-5 py-2 fw-bold">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 2. EDIT ADMIN MODAL -->
<div class="modal fade" id="editAdminModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <!-- <form> -->
                <form id="editAdminForm" method="POST">
                        @csrf
                        @method('PUT')
                    <input type="hidden" id="user_id" name="user_id">
                    <div class="mb-4">
                        <label class="form-label">Name:</label>
                        <input type="text" class="form-control form-control-lg" id="edit_name" name="name">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email:</label>
                        <input type="email" class="form-control form-control-lg" name="email" id="edit_email">
                    </div>
                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 3. SHOW ADMIN MODAL (View Only) -->
<div class="modal fade" id="showAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Show Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-light rounded-bottom">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                        <i class="bi bi-person-fill fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-dark"><span id="show_name"></span></h4>
                        <span class="text-muted small">System Administrator</span>
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="mb-3"><strong class="text-dark me-2">Name:</strong><span id="show_adminname"></span></p>
                        <p class="mb-0"><strong class="text-dark me-2">Email:</strong><span id="show_email"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- 2. Bootstrap (optional but usually needed) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- 3. DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- 4. DataTables Bootstrap -->
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $('body').on('click', '.edit-admin-btn', function () {
        var id = $(this).data('id');
        $('#admin_id').val(id);
        $.ajax({
            url: "/get-admin/" + id,
            type: "GET",

            success: function (response) {
                if (response.status == "success") {
                    var user = response.data;
                    $('#edit_name').val(user.name);
                    $('#edit_email').val(user.email);
                    
                    $('#editAdminForm').attr(
                        'action',
                        '/admin/admins/' + user.id
                    );
                }
            }
        });
    });
    $('body').on('click', '.show-admin-btn', function () {
        var id = $(this).data('id');
        $.ajax({
            url: "/get-admin/" + id,
            type: "GET",
            success: function (response) {
                if (response.status == "success") {
                    var user = response.data;
                    $('#show_name').text(user.name);
                     $('#show_adminname').text(user.name);
                    $('#show_email').text(user.email);
                    // IMPORTANT — open modal
                    $('#showAdminModal').modal('show');
                }
            }
        });
    });
  $(document).ready(function(){
    
    $('#user_table').DataTable({
        "processing": true,
        "serverSide": true,
         stateSave: true,
         autoWidth: false,
        "order": [[ 0, "desc" ]],
         dom: '<"d-flex justify-content-between align-items-center mb-2"l f>rt<"d-flex justify-content-between align-items-center mt-2"i p>',

         ajax: "{{route('adminlist')}}",
         columns: [
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'action', name: 'action'},

        ],
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
</script>
@endsection
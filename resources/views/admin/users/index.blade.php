@extends('admin.layouts.app')

@section('content')
<div class="content-area">
    <!-- Header with Create Button -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <h3 class="mb-0 fw-bold">List Users</h3>
        <button class="btn btn-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-lg me-1"></i> Create New User
        </button>
    </div>
@if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="mb-0">{{ $message }}</p>
        </div>
    @endif
    <!-- Users Table Card -->
    <div class="card">
        <div class="card-body">
            <!-- Responsive Table -->
           <div class="col-sm-12">
            <div class="table-responsive">
                <table id="user_table" class="table table-bordered table-hover dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Activation</th>
                            <th class="text-end">Action</th>
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

<!-- ============================== MODALS (unchanged functionality) ============================== -->

<!-- 1. ADD NEW USER MODAL -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- <form> -->
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control" placeholder="Name" value="{{ old('name') }}" name="name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Company Name:</label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}" class="form-control" placeholder="Company Name">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alternate Email: <small class="text-muted">(add multiple emails with comma separated)</small></label>
                        <input type="text" class="form-control" placeholder="Alternate Email" name="alt_email" value="{{ old('alt_email') }}">
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Mobile:</label>
                            <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control" placeholder="Mobile">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status:</label>
                            <select class="form-select" name="status">
                                <option value="Free">Free</option>
                                 <option value="Paid">Paid</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="tenderActiveNew" name="is_tender" value="1">
                                <label class="form-check-label fw-bold" for="tenderActiveNew">Tender Active</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="resultActiveNew" name="is_result" value="1">
                                <label class="form-check-label fw-bold" for="resultActiveNew">Result Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-5">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 2. EDIT USER MODAL -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- <form> -->
            <form id="editUserForm" method="POST">
                        @csrf
                        @method('PUT')
                    <input type="hidden" id="user_id" name="user_id">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control" id="edit_name" name="name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Company Name:</label>
                            <input type="text" class="form-control" id="edit_company_name" name="company_name">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" name="email" id="edit_email" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alternate Email: <small class="text-muted">(add multiple emails with comma separated)</small></label>
                        <input type="text" name="alt_email" id="edit_alt_email" class="form-control" placeholder="Alternate Email">
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Mobile:</label>
                            <input type="text" name="mobile" id="edit_mobile" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status:</label>
                            <select class="form-select" id="edit_status" name="status">
                                <option value="Free">Free</option>
                                <option value="Paid">Paid</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_is_tender tenderActiveEdit" name="is_tender" checked>
                                <label class="form-check-label fw-bold" for="tenderActiveEdit">Tender Active</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_is_result resultActiveEdit" name="is_result">
                                <label class="form-check-label fw-bold" for="resultActiveEdit">Result Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-5">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 3. SHOW DETAILS MODAL -->
<div class="modal fade" id="showProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Show Product / User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <h5 class="mb-3 text-primary border-bottom pb-2">User Information</h5>
                <p class="mb-2">
                    <strong class="text-dark me-2">Name:</strong>
                    <span id="show_name"></span>
                </p>

                <p class="mb-2">
                    <strong class="text-dark me-2">Company Name:</strong>
                    <span id="show_company_name"></span>
                </p>

                <p class="mb-2">
                    <strong class="text-dark me-2">Email:</strong>
                    <span id="show_email"></span>
                </p>

                <p class="mb-2">
                    <strong class="text-dark me-2">Alternate Email:</strong>
                    <span id="show_alt_email"></span>
                </p>

                <p class="mb-2">
                    <strong class="text-dark me-2">Mobile:</strong>
                    <span id="show_mobile"></span>
                </p>

                <p class="mb-0">
                    <strong class="text-dark me-2">Status:</strong>
                    <span id="show_status"></span>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- 1. jQuery (FIRST) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- 2. Bootstrap (optional but usually needed) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- 3. DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- 4. DataTables Bootstrap -->
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $('body').on('click', '.edit-user-btn', function () {
        var id = $(this).data('id');
        $('#user_id').val(id);
        $.ajax({
            url: "/get-user/" + id,
            type: "GET",

            success: function (response) {
                if (response.status == "success") {
                    var user = response.data;
                    $('#edit_name').val(user.name);
                    $('#edit_company_name').val(user.company_name);
                    $('#edit_email').val(user.email);
                    $('#edit_alt_email').val(user.alt_email);
                    $('#edit_mobile').val(user.mobile);
                    $('#edit_status').val(user.status);

                    if (user.is_tender == 1) {
                        $('#edit_is_tender').prop('checked', true);
                    } else {
                        $('#edit_is_tender').prop('checked', false);
                    }
                    if (user.is_result == 1) {
                        $('#edit_is_result').prop('checked', true);
                    } else {
                        $('#edit_is_result').prop('checked', false);
                    }
                    $('#editUserForm').attr(
                        'action',
                        '/admin/users/' + user.id
                    );
                }
            }
        });
    });
    $('body').on('click', '.show-btn', function () {
        var id = $(this).data('id');
        $.ajax({
            url: "/get-user/" + id,
            type: "GET",
            success: function (response) {
                if (response.status == "success") {
                    var user = response.data;
                    $('#show_name').text(user.name);
                    $('#show_company_name').text(user.company_name);
                    $('#show_email').text(user.email);
                    $('#show_alt_email').text(user.alt_email ?? '-');
                    $('#show_mobile').text(user.mobile);
                    if (user.status == 'Paid') {
                        $('#show_status').html(
                            '<span class="badge bg-success">Paid</span>'
                        );
                    } else {
                        $('#show_status').html(
                            '<span class="badge bg-secondary">Free</span>'
                        );
                    }
                    // IMPORTANT — open modal
                    $('#showProductModal').modal('show');
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
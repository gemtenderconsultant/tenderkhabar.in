@extends('admin.layouts.app')

@section('content')
<div class="content-area">

    <!-- Page Header (no create button as per original) -->
    <div class="mb-4">
        <h3 class="mb-0 fw-bold">List UserServiceInquiry</h3>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="mb-0">{{ $message }}</p>
        </div>
    @endif
    <!-- Inquiries Table Card -->
    <div class="card">
        <div class="card-body p-4">
           <div class="col-sm-12">
            <div class="table-responsive">
                <table id="user_service_inquiry_table" class="table table-bordered table-hover dataTable">
                    <thead>
                        <tr role="row">
                            <th># <i class="bi bi-arrow-down-up ms-1 text-muted" style="font-size: 0.7rem;"></i></th>
                            <th>Name <i class="bi bi-arrow-down-up ms-1 text-muted" style="font-size: 0.7rem;"></i></th>
                            <th>Email <i class="bi bi-arrow-down-up ms-1 text-muted" style="font-size: 0.7rem;"></i></th>
                            <th>Company <i class="bi bi-arrow-down-up ms-1 text-muted" style="font-size: 0.7rem;"></i></th>
                            <th>Phone <i class="bi bi-arrow-down-up ms-1 text-muted" style="font-size: 0.7rem;"></i></th>
                            <th>Date <i class="bi bi-arrow-down-up ms-1 text-muted" style="font-size: 0.7rem;"></i></th>
                            <th>Flag <i class="bi bi-arrow-down-up ms-1 text-muted" style="font-size: 0.7rem;"></i></th>
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
  $(document).ready(function(){
    
    $('#user_service_inquiry_table').DataTable({
        "processing": true,
        "serverSide": true,
         stateSave: true,
         autoWidth: false,
        "order": [[ 0, "desc" ]],
         dom: '<"d-flex justify-content-between align-items-center mb-2"l f>rt<"d-flex justify-content-between align-items-center mt-2"i p>',

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
@extends('admin.layouts.app')
@section('content')
<div class="content-area">
    <!-- Page welcome row -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1 fw-bold">Dashboard</h3>
            <p class="text-muted mb-0 small">Welcome back, here is what's happening today.</p>
        </div>
    </div>
    <!-- Statistics Cards Row (no hover animation, only clean grid) -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small">TOTAL CLIENTS</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $count_total }}</h2>
                    </div>
                    <div class="icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small">ACTIVE CLIENTS</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $activecount }}</h2>
                    </div>
                    <div class="icon-box bg-success bg-opacity-10 text-success">
                        <i class="bi bi-person-check-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small">TOTAL INQUIRIES</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $count_inquriy }}</h2>
                    </div>
                    <div class="icon-box bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-headset fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small">PENDING ACTIVATION</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $pendingcount }}</h2>
                    </div>
                    <div class="icon-box bg-info bg-opacity-10 text-info">
                        <i class="bi bi-lightning-charge-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Recent Inquiries & Client Overview Row -->
    <div class="row g-4">
        <div class="col-12 col-lg-12">
            <div class="card h-100">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4 pb-2">
                    <h5 class="fw-bold mb-0">Recent Service Inquiries</h5>
                    <a href="{{ route('userserviceinquiry') }}" class="btn btn-sm btn-light border text-primary fw-medium">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="inquriy_table" class="table table-bordered table-hover dataTable">
                        <!-- <table class="table table-hover mb-0"> -->
                            <thead>
                                <tr>
                                    <th class="ps-4">Name / Company</th>
                                    <th>Contact Info</th>
                                    <th>Date</th>
                                    <th class="pe-4">Flag</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
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
   $(document).ready(function () {
    $('#inquriy_table').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        autoWidth: false,
        searching: false,     // search box hide
        lengthChange: false,  // show entries hide
        info: false,          // showing entries info hide
        paging: false,        // pagination hide
        ajax: "{{ route('inquriylist') }}",

        columns: [
            { data: 'company', name: 'name' },
            { data: 'contact', name: 'email' },
            { data: 'date', name: 'created_at' },
            { data: 'flag', name: 'flag', orderable: false, searchable: false },
        ]
    });
   });
</script>
@endsection
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
        <h1>Blogs</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('blog-list')}}">Blogs</a></li>
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
        @if(Session::has('successMsg'))
          <div class="alert alert-success"> {{ Session::get('successMsg') }}</div>
        @endif
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Blog List</h3>
            <div class="card-action">
              <a href="{{ route('blog-create') }}" class="btn btn-primary float-right">Create</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12">
                  <table id="blog_table" class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                    <thead>
                      <tr role="row">
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>UploadBy</th>
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
    $('#blog_table').DataTable({
       processing: true,
       serverSide: true,
       order:['0','desc'],
       ajax: "{{route('blog-list')}}",
       columns: [
          { data: 'id' },
          { data: 'name' },
          { data: 'description' },
          { data: 'category' },
          { data: 'uploadby' },
          { data: 'action' },
       ]
    });
  });
</script>
@endsection
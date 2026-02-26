@extends('admin.layouts.app')
@section('stylesheet')
  
@endsection
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>News Ticket View</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('newsticket-list')}}">News Tickets View</a></li>
          <li class="breadcrumb-item"><a href="{{route('newsticket-view',$newsticket->id)}}">{{$newsticket->id}}</a></li>
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
            <h3 class="card-title">News Tickets View</h3>
            <div class="card-action text-right">
              <a href="{{ route('newsticket-edit',$newsticket->id)}}" class="btn btn-primary">Update</a>
              <a href="{{ route('newsticket-delete',$newsticket->id) }}" class="btn btn-danger">Delete</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12">
                  <table id="user_table" class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                    <tbody>
                      <tr>
                        <td><strong>ID</strong></td>
                        <td>{{$newsticket->id}}</td>
                      </tr>
                      <tr>
                        <td><strong>Subject</strong></td>
                        <td>{{$newsticket->subject}}</td>
                      </tr>
                      <tr>
                        <td><strong>Message</strong></td>
                        <td>{{$newsticket->message}}</td>
                      </tr>
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
<script type="text/javascript">
</script>
@endsection